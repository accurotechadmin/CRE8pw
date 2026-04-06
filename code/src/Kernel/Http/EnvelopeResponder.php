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
}
