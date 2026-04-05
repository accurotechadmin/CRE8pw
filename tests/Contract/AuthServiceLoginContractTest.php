<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Application\Auth\AuthService;
use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\JwtTokenSigner;
use PHPUnit\Framework\TestCase;

final class AuthServiceLoginContractTest extends TestCase
{
    public function testLoginReturnsStringRefreshTokenFromIssuedTokenPair(): void
    {
        if (!function_exists('openssl_pkey_new')) {
            self::markTestSkipped('openssl extension is required for JWT signing');
        }

        [$privateKey, $publicKey] = $this->generateKeyPair();
        $config = new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: '',
            dbPass: '',
            jwtIssuer: 'https://cre8.test',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $privateKey,
            jwtPublicKey: $publicKey,
            corsAllowedOrigins: ['http://localhost:3000'],
            csrfSecret: str_repeat('x', 32),
        );

        $auth = new AuthService(
            new JwtTokenSigner($config),
            $config,
            new class implements AuditEmitter {
                public function emit(string $event, array $payload = []): void
                {
                }
            },
            new \PDO('sqlite::memory:'),
        );

        $auth->registerOwner('owner@example.com', 'very-strong-password-123', 'req-register');
        $tokens = $auth->login('owner@example.com', 'very-strong-password-123', 'req-login');

        self::assertIsString($tokens['access_token'] ?? null);
        self::assertIsString($tokens['refresh_token'] ?? null);
        self::assertSame(900, $tokens['expires_in'] ?? null);
    }

    /** @return array{string,string} */
    private function generateKeyPair(): array
    {
        $resource = openssl_pkey_new([
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'private_key_bits' => 2048,
        ]);
        self::assertNotFalse($resource);

        openssl_pkey_export($resource, $privateKey);
        $details = openssl_pkey_get_details($resource);
        self::assertIsArray($details);
        $publicKey = (string) ($details['key'] ?? '');

        self::assertNotSame('', $privateKey);
        self::assertNotSame('', $publicKey);

        return [$privateKey, $publicKey];
    }
}
