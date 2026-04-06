<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract\Public;

use Cre8\Kernel\Bootstrap\AppFactory;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

final class OwnerLoginRouteContractTest extends TestCase
{
    public function testOwnerLoginReturnsTokenEnvelopeForValidCredentials(): void
    {
        $app = (new AppFactory())->create();
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/api/auth/login')
            ->withHeader('Content-Type', 'application/json');
        $request->getBody()->write((string) json_encode([
            'email' => 'owner@example.com',
            'password' => 'StrongPassphrase123!',
        ], JSON_THROW_ON_ERROR));

        $response = $app->handle($request);
        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('1', $response->getHeaderLine('X-Envelope-Version'));
        self::assertArrayHasKey('data', $payload);
        self::assertArrayHasKey('access_token', $payload['data']);
        self::assertArrayHasKey('refresh_token', $payload['data']);
        self::assertSame(900, $payload['data']['expires_in']);
    }
}
