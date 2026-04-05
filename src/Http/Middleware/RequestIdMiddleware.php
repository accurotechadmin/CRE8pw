<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Request\RequestId;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestIdMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly ?AuditEmitter $auditEmitter = null)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $incomingRequestId = trim($request->getHeaderLine('X-Request-Id'));
        $acceptedIncoming = $incomingRequestId !== '' && RequestId::isUuidV4($incomingRequestId);

        $requestId = $acceptedIncoming ? $incomingRequestId : RequestId::generate();

        if (! $acceptedIncoming && $incomingRequestId !== '') {
            $this->auditEmitter?->emit('request_id.invalid_replaced', [
                'incoming_request_id' => $incomingRequestId,
                'request_id' => $requestId,
            ]);
        }

        $response = $handler->handle($request
            ->withAttribute('request_id', $requestId)
            ->withAttribute('request_id_source', $acceptedIncoming ? 'incoming' : 'generated'));

        return $response->withHeader('X-Request-Id', $requestId);
    }

}
