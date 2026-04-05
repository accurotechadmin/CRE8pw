<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Application\Health\HealthService;
use Cre8\Config\RuntimeConfig;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

final class HealthServiceContractTest extends TestCase
{
    public function testHealthServiceReturnsStructuredSubsystemProbes(): void
    {
        $private = tempnam(sys_get_temp_dir(), 'priv-');
        $public = tempnam(sys_get_temp_dir(), 'pub-');
        file_put_contents($private, "-----BEGIN PRIVATE KEY-----\nabc\n-----END PRIVATE KEY-----\n");
        file_put_contents($public, "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----\n");

        $config = new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: '',
            dbPass: '',
            jwtIssuer: 'https://issuer.local',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $private,
            jwtPublicKey: $public,
            corsAllowedOrigins: ['https://console.local'],
            csrfSecret: str_repeat('a', 32),
        );

        $service = new HealthService(
            new \PDO('sqlite::memory:'),
            new Client(['http_errors' => false]),
            new RateLimiterFactory([
                'id' => 'health',
                'policy' => 'fixed_window',
                'interval' => '1 minute',
                'limit' => 100,
            ], new CacheStorage(new ArrayAdapter())),
            $config,
        );

        $health = $service->check();

        self::assertArrayHasKey('checked_at_utc', $health);
        self::assertArrayHasKey('latency_ms', $health);
        self::assertArrayHasKey('failures', $health);
        self::assertSame('ok', $health['services']['db']['status']);
        self::assertSame('ok', $health['services']['rate_limiter']['status']);
        self::assertSame('ok', $health['services']['key_material']['status']);

        @unlink($private);
        @unlink($public);
    }
}
