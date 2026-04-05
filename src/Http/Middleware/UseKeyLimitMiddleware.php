<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class UseKeyLimitMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $principal = $request->getAttribute('principal');
        $keyClass = is_array($principal) ? (string) ($principal['key_class'] ?? '') : '';
        if ($keyClass !== 'use') {
            return $handler->handle($request);
        }

        $path = $request->getUri()->getPath();
        $method = strtoupper($request->getMethod());
        if ($path === '/api/posts' && $method === 'POST') {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.use_key_limit.rejected', [
                'request_id' => $requestId,
                'path' => $path,
                'method' => $method,
                'detail_code' => 'use_key_post_create_forbidden',
            ]);

            return $this->responder->error('forbidden', 'use key cannot create posts', $requestId, 403, [
                'detail_code' => 'use_key_post_create_forbidden',
            ]);
        }

        if (str_starts_with($path, '/api/keys') && in_array($method, ['POST', 'PATCH', 'DELETE'], true)) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.use_key_limit.rejected', [
                'request_id' => $requestId,
                'path' => $path,
                'method' => $method,
                'detail_code' => 'use_key_key_mutation_forbidden',
            ]);

            return $this->responder->error('forbidden', 'use key cannot mutate keys', $requestId, 403, [
                'detail_code' => 'use_key_key_mutation_forbidden',
            ]);
        }

        $this->auditEmitter?->emit('auth.use_key_limit.allowed', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $path,
            'method' => $method,
            'key_class' => $keyClass,
        ]);

        return $handler->handle($request);
    }
}
