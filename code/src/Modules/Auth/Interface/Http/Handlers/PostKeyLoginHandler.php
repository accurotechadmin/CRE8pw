<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Interface\Http\Handlers;

use Cre8\Kernel\Http\EnvelopeResponder;
use Cre8\Modules\Auth\Application\UseCases\KeyAuthenticationFailed;
use Cre8\Modules\Auth\Application\UseCases\LoginKey;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

final class PostKeyLoginHandler
{
    public function __construct(
        private readonly LoginKey $useCase,
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

        $keyId = $decoded['key_id'] ?? null;
        $apiKey = $decoded['api_key'] ?? null;

        if (!is_string($keyId) || $keyId === '' || !is_string($apiKey) || $apiKey === '') {
            return $this->responder->error(
                code: 'validation_failed',
                message: 'key_id and api_key are required.',
                status: 422,
                requestId: $requestId,
                details: ['field' => 'key_id|api_key']
            );
        }

        try {
            $result = $this->useCase->execute($keyId, $apiKey);
        } catch (KeyAuthenticationFailed) {
            return $this->responder->error(
                code: 'auth_invalid',
                message: 'Invalid key credentials.',
                status: 401,
                requestId: $requestId
            );
        }

        return $this->responder->success($result, 200);
    }
}
