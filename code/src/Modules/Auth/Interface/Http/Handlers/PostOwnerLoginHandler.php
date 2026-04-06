<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Interface\Http\Handlers;

use Cre8\Kernel\Http\EnvelopeResponder;
use Cre8\Modules\Auth\Application\UseCases\LoginOwner;
use Cre8\Modules\Auth\Application\UseCases\OwnerAuthenticationFailed;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

final class PostOwnerLoginHandler
{
    public function __construct(
        private readonly LoginOwner $useCase,
        private readonly EnvelopeResponder $responder
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $requestId = $request->getHeaderLine('X-Request-Id') ?: ('req_' . bin2hex(random_bytes(8)));

        try {
            $decoded = json_decode((string) $request->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            return $this->responder->error(
                code: 'validation_failed',
                message: 'Request body must be valid JSON.',
                status: 422,
                requestId: $requestId,
                details: ['field' => 'body']
            );
        }

        if (!is_array($decoded)) {
            return $this->responder->error(
                code: 'validation_failed',
                message: 'Request body must be a JSON object.',
                status: 422,
                requestId: $requestId,
                details: ['field' => 'body']
            );
        }

        $email = $decoded['email'] ?? null;
        $password = $decoded['password'] ?? null;

        if (!is_string($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !is_string($password) || $password === '') {
            return $this->responder->error(
                code: 'validation_failed',
                message: 'email and password are required.',
                status: 422,
                requestId: $requestId,
                details: ['field' => 'email|password']
            );
        }

        try {
            $result = $this->useCase->execute($email, $password);
        } catch (OwnerAuthenticationFailed) {
            return $this->responder->error(
                code: 'auth_invalid',
                message: 'Invalid credentials.',
                status: 401,
                requestId: $requestId
            );
        }

        return $this->responder->success($result, 200);
    }
}
