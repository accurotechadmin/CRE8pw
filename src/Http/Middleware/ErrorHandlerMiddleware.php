<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use DomainException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ErrorHandlerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            [$code, $message, $status, $detailCode] = $this->mapException($exception);
            $requestId = (string) $request->getAttribute('request_id', 'unknown');

            $this->auditEmitter?->emit('http.error_handled', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'status' => $status,
                'code' => $code,
                'detail_code' => $detailCode,
                'exception_class' => $exception::class,
            ]);

            return $this->responder->error($code, $message, $requestId, $status, [
                'detail_code' => $detailCode,
            ]);
        }
    }

    /** @return array{0:string,1:string,2:int,3:string} */
    private function mapException(\Throwable $exception): array
    {
        if ($exception instanceof InvalidArgumentException) {
            return ['bad_request', 'invalid request payload', 400, 'invalid_argument'];
        }

        if ($exception instanceof DomainException) {
            return ['validation_failed', 'domain policy validation failed', 422, 'domain_validation'];
        }

        return ['internal_error', 'unexpected server failure', 500, 'unhandled_exception'];
    }
}
