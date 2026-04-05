<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Core\Http\EnvelopeResponder;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ResponseFactory;

final class EnvelopeResponderContractTest extends TestCase
{
    public function testListEnvelopeIncludesPagingHasMoreAndMeta(): void
    {
        $responder = new EnvelopeResponder(new ResponseFactory());
        $response = $responder->list([['id' => 'p1']], 'cursor-1', 10);

        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame(10, $payload['paging']['limit']);
        self::assertTrue($payload['paging']['has_more']);
        self::assertArrayHasKey('timestamp_utc', $payload['meta']);
        self::assertSame('2026-04-03', $payload['meta']['envelope_version']);
    }

    public function testErrorEnvelopeAddsVersionHeaderAndRequestMeta(): void
    {
        $responder = new EnvelopeResponder(new ResponseFactory());
        $response = $responder->error('forbidden', 'nope', 'req-1', 403);
        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('2026-04-03', $response->getHeaderLine('X-Envelope-Version'));
        self::assertSame('req-1', $payload['error']['request_id']);
        self::assertSame('req-1', $payload['meta']['request_id']);
    }
}
