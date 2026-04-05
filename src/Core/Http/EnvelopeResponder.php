<?php

declare(strict_types=1);

namespace Cre8\Core\Http;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class EnvelopeResponder
{
    private const ENVELOPE_VERSION = '2026-04-03';

    public function __construct(private readonly ResponseFactoryInterface $responseFactory)
    {
    }

    /** @param array<string,mixed> $data @param array<string,mixed> $meta */
    public function success(array $data, int $status = 200, array $meta = []): ResponseInterface
    {
        return $this->json($status, ['data' => $data, 'meta' => $this->meta($meta)]);
    }

    /** @param list<array<string,mixed>> $data @param array<string,mixed> $meta */
    public function list(array $data, ?string $cursor, int $limit = 50, array $meta = []): ResponseInterface
    {
        return $this->json(200, [
            'data' => $data,
            'paging' => [
                'limit' => $limit,
                'cursor' => $cursor,
                'has_more' => $cursor !== null && $cursor !== '',
            ],
            'meta' => $this->meta($meta),
        ]);
    }

    /** @param array<string,mixed>|list<array<string,mixed>> $details */
    public function error(string $code, string $message, string $requestId, int $status, array $details = []): ResponseInterface
    {
        return $this->json($status, [
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details,
                'request_id' => $requestId,
            ],
            'meta' => $this->meta(['request_id' => $requestId]),
        ], ['X-Request-Id' => $requestId, 'X-Envelope-Version' => self::ENVELOPE_VERSION]);
    }

    /** @param array<string,mixed> $payload @param array<string,string> $headers */
    public function json(int $status, array $payload, array $headers = []): ResponseInterface
    {
        $response = $this->responseFactory
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('X-Envelope-Version', self::ENVELOPE_VERSION);
        foreach ($headers as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        $response->getBody()->write((string) json_encode($payload, JSON_THROW_ON_ERROR));

        return $response;
    }

    /** @param array<string,mixed> $meta @return array<string,mixed> */
    private function meta(array $meta): array
    {
        return array_merge([
            'envelope_version' => self::ENVELOPE_VERSION,
            'timestamp_utc' => gmdate('c'),
        ], $meta);
    }
}
