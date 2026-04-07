<?php

declare(strict_types=1);

namespace Cre8\Tests\Security\Auth;

use Cre8\Kernel\Bootstrap\AppFactory;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

final class KeyLoginSecurityTest extends TestCase
{
    public function testKeyLoginRejectsInvalidCredentialsWith401ErrorEnvelope(): void
    {
        $app = (new AppFactory())->create();
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/api/auth/key-login')
            ->withHeader('Content-Type', 'application/json');
        $request->getBody()->write((string) json_encode([
            'key_id' => 'key_123',
            'api_key' => 'invalid',
        ], JSON_THROW_ON_ERROR));

        $response = $app->handle($request);
        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(401, $response->getStatusCode());
        self::assertSame('auth_invalid', $payload['error']['code']);
        self::assertNotSame('', $response->getHeaderLine('X-Request-Id'));
    }

    public function testKeyLoginRejectsMalformedPayloadWith422ErrorEnvelope(): void
    {
        $app = (new AppFactory())->create();
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/api/auth/key-login')
            ->withHeader('X-Request-Id', 'req_key_422')
            ->withHeader('Content-Type', 'application/json');
        $request->getBody()->write((string) json_encode([
            'key_id' => '',
            'api_key' => '',
        ], JSON_THROW_ON_ERROR));

        $response = $app->handle($request);
        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(422, $response->getStatusCode());
        self::assertSame('validation_failed', $payload['error']['code']);
        self::assertSame('req_key_422', $payload['error']['request_id']);
    }
}
