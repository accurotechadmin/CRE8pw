<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CorsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly RuntimeConfig $config,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $origin = $request->getHeaderLine('Origin');
        $isPreflight = strtoupper($request->getMethod()) === 'OPTIONS';
        $wildcardAllowed = in_array('*', $this->config->corsAllowedOrigins, true);
        $allowed = $origin !== '' && ($wildcardAllowed || in_array($origin, $this->config->corsAllowedOrigins, true));

        if ($isPreflight) {
            if ($origin === '') {
                $this->auditEmitter?->emit('cors.preflight_rejected', [
                    'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                    'path' => $request->getUri()->getPath(),
                    'detail_code' => 'cors_origin_missing',
                ]);

                return $this->responseFactory->createResponse(400)
                    ->withHeader('X-Cors-Error-Code', 'cors_origin_missing')
                    ->withHeader('Content-Type', 'application/json; charset=utf-8');
            }

            if (!$allowed) {
                $this->auditEmitter?->emit('cors.preflight_rejected', [
                    'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                    'path' => $request->getUri()->getPath(),
                    'origin' => $origin,
                    'detail_code' => 'cors_origin_disallowed',
                ]);

                return $this->responseFactory->createResponse(403)
                    ->withHeader('X-Cors-Error-Code', 'cors_origin_disallowed')
                    ->withHeader('Content-Type', 'application/json; charset=utf-8');
            }

            $response = $this->responseFactory->createResponse(204);
        } else {
            $response = $handler->handle($request);
        }

        if (!$allowed) {
            return $response;
        }

        $this->auditEmitter?->emit('cors.applied', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
            'origin' => $origin,
            'preflight' => $isPreflight,
        ]);

        return $response
            ->withHeader('Access-Control-Allow-Origin', $wildcardAllowed ? '*' : $origin)
            ->withHeader('Vary', 'Origin')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, X-CSRF-Token, X-Request-Id')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS');
    }
}
