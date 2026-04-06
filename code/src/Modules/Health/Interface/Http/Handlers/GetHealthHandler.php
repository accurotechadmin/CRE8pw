<?php

declare(strict_types=1);

namespace Cre8\Modules\Health\Interface\Http\Handlers;

use Cre8\Kernel\Http\EnvelopeResponder;
use Cre8\Modules\Health\Application\UseCases\GetHealthStatus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetHealthHandler
{
    public function __construct(
        private readonly GetHealthStatus $useCase,
        private readonly EnvelopeResponder $responder
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->responder->success($this->useCase->execute());
    }
}
