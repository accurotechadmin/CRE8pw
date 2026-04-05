<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Config\RuntimeConfig;
use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CsrfMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly RuntimeConfig $config,
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $method = strtoupper($request->getMethod());
        if (!str_starts_with($path, '/console/') || str_starts_with($path, '/console/api/') || !in_array($method, ['POST', 'PATCH', 'DELETE'], true)) {
            return $handler->handle($request);
        }

        $token = $request->getHeaderLine('X-CSRF-Token');
        $expected = hash_hmac('sha256', (string) $request->getAttribute('request_id', 'unknown'), $this->config->csrfSecret);

        if ($token === '') {
            $this->auditEmitter?->emit('csrf.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $path,
                'method' => $method,
                'detail_code' => 'csrf_token_missing',
            ]);

            return $this->responder->error('forbidden', 'csrf validation failed', (string) $request->getAttribute('request_id', 'unknown'), 403, [
                'detail_code' => 'csrf_token_missing',
            ]);
        }

        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            $this->auditEmitter?->emit('csrf.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $path,
                'method' => $method,
                'detail_code' => 'csrf_token_malformed',
            ]);

            return $this->responder->error('forbidden', 'csrf validation failed', (string) $request->getAttribute('request_id', 'unknown'), 403, [
                'detail_code' => 'csrf_token_malformed',
            ]);
        }

        if (sodium_memcmp($expected, $token) !== 0) {
            $this->auditEmitter?->emit('csrf.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $path,
                'method' => $method,
                'detail_code' => 'csrf_token_mismatch',
            ]);

            return $this->responder->error('forbidden', 'csrf validation failed', (string) $request->getAttribute('request_id', 'unknown'), 403, [
                'detail_code' => 'csrf_token_mismatch',
            ]);
        }

        $this->auditEmitter?->emit('csrf.validated', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $path,
            'method' => $method,
        ]);

        return $handler->handle($request);
    }
}
