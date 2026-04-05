<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;

final class RateLimitMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly RateLimiterFactory $rateLimiter,
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $key = trim((string) ($request->getServerParams()['REMOTE_ADDR'] ?? ''));
        if ($key === '') {
            $key = 'ip:unknown';
        }

        $limit = $this->rateLimiter->create((string) $key)->consume(1);

        if (!$limit->isAccepted()) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $retryAfter = $limit->getRetryAfter()?->getTimestamp();
            $this->auditEmitter?->emit('rate_limit.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'client_key' => $key,
                'detail_code' => 'rate_limit_exceeded',
                'retry_after' => $retryAfter,
            ]);

            return $this->responder->error('rate_limited', 'rate limit exceeded', $requestId, 429, [
                'detail_code' => 'rate_limit_exceeded',
                'retry_after' => $retryAfter,
            ]);
        }

        $this->auditEmitter?->emit('rate_limit.accepted', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
            'client_key' => $key,
        ]);

        return $handler->handle($request);
    }
}
