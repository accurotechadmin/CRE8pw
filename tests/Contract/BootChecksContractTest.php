<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Bootstrap\BootChecks;
use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\TokenSigner;
use Cre8\Security\TokenVerificationResult;
use Cre8\Security\TokenVerifier;
use Cre8\Security\VerifiedPrincipal;
use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;

final class BootChecksContractTest extends TestCase
{
    public function testBootChecksWritesStructuredEvidenceWhenConfigured(): void
    {
        [$private, $public] = $this->keyFiles();
        $evidencePath = tempnam(sys_get_temp_dir(), 'boot-evidence-');
        putenv('BOOT_EVIDENCE_PATH=' . $evidencePath);

        BootChecks::assert($this->container(), $this->config($private, $public, 'local'));

        $decoded = json_decode((string) file_get_contents($evidencePath), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('ok', $decoded['status']);
        self::assertSame('local', $decoded['app_env']);
        self::assertSame('path', $decoded['key_sources']['private']);

        @unlink($private);
        @unlink($public);
        @unlink($evidencePath);
        putenv('BOOT_EVIDENCE_PATH');
    }

    public function testBootChecksRejectsProdWildcardCorsProfile(): void
    {
        [$private, $public] = $this->keyFiles();
        $config = new RuntimeConfig(
            appEnv: 'prod',
            dbDsn: 'pgsql:host=localhost;dbname=cre8',
            dbUser: 'cre8',
            dbPass: 'cre8-pass',
            jwtIssuer: 'https://issuer.cre8.local',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $private,
            jwtPublicKey: $public,
            corsAllowedOrigins: ['*'],
            csrfSecret: str_repeat('a', 32),
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('wildcard CORS not allowed in prod');

        BootChecks::assert($this->container(), $config);
    }

    private function container(): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            TokenVerifier::class => static fn () => new class implements TokenVerifier {
                public function verify(string $token): TokenVerificationResult
                {
                    return new TokenVerificationResult(['sub' => 'owner', 'typ' => 'owner', 'aud' => 'console'], new VerifiedPrincipal('owner', 'owner', 'console'));
                }
            },
            TokenSigner::class => static fn () => new class implements TokenSigner {
                public function sign(array $claims, string $tokenClass = 'access', array $context = [], ?int $expiresInSeconds = null): string
                {
                    return 'signed';
                }
            },
            AuditEmitter::class => static fn () => new class implements AuditEmitter {
                public function emit(string $event, array $payload = []): void
                {
                }
            },
            \PDO::class => static fn () => new \PDO('sqlite::memory:'),
        ]);

        return $builder->build();
    }

    private function config(string $private, string $public, string $env): RuntimeConfig
    {
        return new RuntimeConfig(
            appEnv: $env,
            dbDsn: 'pgsql:host=localhost;dbname=cre8',
            dbUser: 'cre8',
            dbPass: 'cre8-pass',
            jwtIssuer: 'https://issuer.cre8.local',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $private,
            jwtPublicKey: $public,
            corsAllowedOrigins: ['https://console.cre8.local'],
            csrfSecret: str_repeat('a', 32),
        );
    }

    /** @return array{string,string} */
    private function keyFiles(): array
    {
        $private = tempnam(sys_get_temp_dir(), 'key-priv-');
        $public = tempnam(sys_get_temp_dir(), 'key-pub-');

        file_put_contents($private, "-----BEGIN PRIVATE KEY-----\nkey\n-----END PRIVATE KEY-----\n");
        file_put_contents($public, "-----BEGIN PUBLIC KEY-----\nkey\n-----END PUBLIC KEY-----\n");

        chmod($private, 0600);
        chmod($public, 0644);

        return [$private, $public];
    }
}
