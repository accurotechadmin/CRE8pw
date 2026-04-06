<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract\Public;

use Cre8\Kernel\Bootstrap\AppFactory;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

final class StatusRouteContractTest extends TestCase
{
    public function testGetRootReturnsServiceStatusEnvelope(): void
    {
        $app = (new AppFactory())->create();
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/');

        $response = $app->handle($request);
        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('1', $response->getHeaderLine('X-Envelope-Version'));
        self::assertSame('cre8', $payload['data']['service']);
        self::assertSame('ok', $payload['data']['status']);
        self::assertArrayHasKey('timestamp_utc', $payload['meta']);
    }
}
