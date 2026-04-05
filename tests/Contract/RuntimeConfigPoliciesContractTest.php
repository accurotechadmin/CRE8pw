<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Config\EnvValidator;
use Cre8\Config\RuntimeConfig;
use PHPUnit\Framework\TestCase;

final class RuntimeConfigPoliciesContractTest extends TestCase
{
    public function testEnvValidatorRejectsInvalidProdIssuerAndDsn(): void
    {
        $env = $this->validEnv();
        $env['APP_ENV'] = 'prod';
        $env['DB_DSN'] = 'sqlite::memory:';
        $env['JWT_ISSUER'] = 'http://issuer.local';

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('config_disallowed_profile');

        EnvValidator::validateRequired($env);
    }

    public function testRuntimeConfigBuildsTypedPolicyObjectsFromEnv(): void
    {
        $env = $this->validEnv();
        $env['RATE_LIMIT_GLOBAL_LIMIT'] = '220';
        $env['RATE_LIMIT_GLOBAL_INTERVAL'] = '2 minutes';
        $env['JWT_OWNER_TTL_SECONDS'] = '901';
        $env['JWT_KEY_TTL_SECONDS'] = '601';
        $env['JWT_DELEGATION_TTL_SECONDS'] = '301';

        $config = RuntimeConfig::fromEnv($env);

        self::assertSame(220, $config->rateLimitPolicy?->limit);
        self::assertSame('2 minutes', $config->rateLimitPolicy?->interval);
        self::assertSame(901, $config->jwtPolicy?->ownerTtlSeconds);
        self::assertSame(601, $config->jwtPolicy?->keyTtlSeconds);
        self::assertSame(301, $config->jwtPolicy?->delegationTtlSeconds);
        self::assertSame(['https://console.cre8.local'], $config->corsPolicy?->allowedOrigins);
    }

    /** @return array<string, string> */
    private function validEnv(): array
    {
        return [
            'APP_ENV' => 'local',
            'DB_DSN' => 'pgsql:host=localhost;dbname=cre8',
            'DB_USER' => 'cre8',
            'DB_PASS' => 'cre8-pass',
            'JWT_ISSUER' => 'https://issuer.cre8.local',
            'JWT_AUDIENCE_CONSOLE' => 'console-aud',
            'JWT_AUDIENCE_GATEWAY' => 'gateway-aud',
            'JWT_PRIVATE_KEY' => '/tmp/private.pem',
            'JWT_PUBLIC_KEY' => '/tmp/public.pem',
            'CORS_ALLOWED_ORIGINS' => 'https://console.cre8.local',
            'CSRF_SECRET' => str_repeat('a', 32),
        ];
    }
}
