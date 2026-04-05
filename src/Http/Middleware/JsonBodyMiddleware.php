<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class JsonBodyMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = strtoupper($request->getMethod());
        if (!in_array($method, ['POST', 'PATCH', 'PUT', 'DELETE'], true)) {
            return $handler->handle($request);
        }

        $contentType = strtolower($request->getHeaderLine('Content-Type'));
        if ($contentType !== '' && !str_contains($contentType, 'application/json')) {
            $this->auditEmitter?->emit('json_body.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'content_type_unsupported',
            ]);

            return $this->responder->error('unsupported_media_type', 'content type must be application/json', (string) $request->getAttribute('request_id', 'unknown'), 415, [
                'detail_code' => 'content_type_unsupported',
            ]);
        }

        $raw = (string) $request->getBody();
        if ($raw === '') {
            return $handler->handle($request->withParsedBody([]));
        }

        try {
            $parsed = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            $this->auditEmitter?->emit('json_body.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'json_malformed',
            ]);

            return $this->responder->error('bad_request', 'malformed json payload', (string) $request->getAttribute('request_id', 'unknown'), 400, [
                'detail_code' => 'json_malformed',
            ]);
        }

        if (!is_array($parsed)) {
            $this->auditEmitter?->emit('json_body.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'json_root_not_object',
            ]);

            return $this->responder->error('bad_request', 'json payload must decode to an object', (string) $request->getAttribute('request_id', 'unknown'), 400, [
                'detail_code' => 'json_root_not_object',
            ]);
        }

        $this->auditEmitter?->emit('json_body.parsed', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
        ]);

        return $handler->handle($request->withParsedBody($parsed));
    }
}
