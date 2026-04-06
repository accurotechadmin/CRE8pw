<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract\Public;

use Cre8\Kernel\Bootstrap\AppFactory;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

final class HealthRouteContractTest extends TestCase
{
    public function testGetHealthReturnsSuccessEnvelope(): void
    {
        $app = (new AppFactory())->create();
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/health');

        $response = $app->handle($request);
        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('1', $response->getHeaderLine('X-Envelope-Version'));
        self::assertArrayHasKey('data', $payload);
        self::assertArrayHasKey('meta', $payload);
        self::assertContains($payload['data']['status'], ['ok', 'degraded']);
    }
}
