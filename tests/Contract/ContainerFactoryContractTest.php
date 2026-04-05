<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Bootstrap\ContainerFactory;
use Cre8\Config\RateLimitPolicy;
use Cre8\Config\RuntimeConfig;
use PHPUnit\Framework\TestCase;

final class ContainerFactoryContractTest extends TestCase
{
    public function testContainerFactoryUsesTypedRateLimitPolicy(): void
    {
        $config = new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: '',
            dbPass: '',
            jwtIssuer: 'https://issuer.local',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: "-----BEGIN PRIVATE KEY-----\nabc\n-----END PRIVATE KEY-----",
            jwtPublicKey: "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----",
            corsAllowedOrigins: ['https://console.local'],
            csrfSecret: str_repeat('a', 32),
            rateLimitPolicy: new RateLimitPolicy(id: 'policy-id', interval: '2 minutes', limit: 25),
        );

        $container = ContainerFactory::build($config);
        self::assertNotNull($container->get(\Symfony\Component\RateLimiter\RateLimiterFactory::class));

        $source = (string) file_get_contents(__DIR__ . '/../../src/Bootstrap/ContainerFactory.php');
        self::assertStringContainsString('$config->rateLimitPolicy?->id', $source);
        self::assertStringContainsString('$config->rateLimitPolicy?->interval', $source);
        self::assertStringContainsString('$config->rateLimitPolicy?->limit', $source);
        self::assertStringContainsString('coreDefinitions', $source);
        self::assertStringContainsString('securityDefinitions', $source);
        self::assertStringContainsString('httpDefinitions', $source);
        self::assertStringContainsString('appDefinitions', $source);
    }
}
