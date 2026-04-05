<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DeviceLimitMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!str_starts_with($request->getUri()->getPath(), '/api/')) {
            return $handler->handle($request);
        }

        $deviceId = trim($request->getHeaderLine('X-Device-Id'));
        if ($deviceId === '') {
            $this->auditEmitter?->emit('device_limit.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'device_id_missing',
            ]);

            return $this->responder->error('validation_failed', 'missing device id', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                ['path' => 'X-Device-Id', 'code' => 'required', 'detail_code' => 'device_id_missing', 'message' => 'device id header required'],
            ]);
        }

        if (preg_match('/^[a-zA-Z0-9_.:-]{8,128}$/', $deviceId) !== 1) {
            $this->auditEmitter?->emit('device_limit.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'device_id_invalid_format',
            ]);

            return $this->responder->error('validation_failed', 'invalid device id format', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                ['path' => 'X-Device-Id', 'code' => 'invalid', 'detail_code' => 'device_id_invalid_format', 'message' => 'device id header must match expected format'],
            ]);
        }

        $this->auditEmitter?->emit('device_limit.validated', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
        ]);

        return $handler->handle($request);
    }
}
