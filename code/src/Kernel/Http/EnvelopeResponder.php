<?php

declare(strict_types=1);

namespace Cre8\Kernel\Http;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class EnvelopeResponder
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly string $envelopeVersion = '1'
    ) {
    }

    /**
     * @param array<string,mixed> $data
     * @param array<string,mixed> $meta
     */
    public function success(array $data, int $status = 200, array $meta = []): ResponseInterface
    {
        $response = $this->responseFactory->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Envelope-Version', $this->envelopeVersion);

        $payload = [
            'data' => $data,
            'meta' => [
                'envelope_version' => $this->envelopeVersion,
                ...$meta,
            ],
        ];

        $response->getBody()->write((string) json_encode($payload, JSON_THROW_ON_ERROR));

        return $response;
    }

    /**
     * @param array<string,mixed> $details
     * @param array<string,mixed> $meta
     */
    public function error(
        string $code,
        string $message,
        int $status,
        string $requestId,
        array $details = [],
        array $meta = []
    ): ResponseInterface {
        $response = $this->responseFactory->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Envelope-Version', $this->envelopeVersion)
            ->withHeader('X-Request-Id', $requestId);

        $payload = [
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details,
                'request_id' => $requestId,
            ],
            'meta' => [
                'envelope_version' => $this->envelopeVersion,
                ...$meta,
            ],
        ];

        $response->getBody()->write((string) json_encode($payload, JSON_THROW_ON_ERROR));

        return $response;
    }
}
