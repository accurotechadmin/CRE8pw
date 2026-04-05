<?php

declare(strict_types=1);

namespace Cre8\Bootstrap;

use Cre8\Config\RuntimeConfig;
use Cre8\Http\Middleware\MiddlewareOrder;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\KeyMaterial;
use Cre8\Security\TokenSigner;
use Cre8\Security\TokenVerifier;
use DI\Container;
use PDO;

final class BootChecks
{
    public static function assert(Container $container, RuntimeConfig $config): void
    {
        $started = microtime(true);
        $container->get(TokenVerifier::class);
        $container->get(TokenSigner::class);
        $container->get(AuditEmitter::class);
        $container->get(PDO::class);

        $requiredClasses = [
            \Slim\App::class,
            \Slim\Psr7\Factory\ResponseFactory::class,
            \DI\Container::class,
            \Firebase\JWT\JWT::class,
            \Respect\Validation\Validator::class,
            \Dotenv\Dotenv::class,
            \GuzzleHttp\Client::class,
            'Neomerx\\Cors\\Strategies\\Settings',
            \Monolog\Logger::class,
            \Symfony\Component\RateLimiter\RateLimiterFactory::class,
            \Symfony\Component\Cache\Adapter\ArrayAdapter::class,
        ];

        foreach ($requiredClasses as $className) {
            if (!class_exists($className)) {
                throw new \RuntimeException(sprintf('Required dependency class missing: %s', $className));
            }
        }

        KeyMaterial::resolve($config->jwtPrivateKey);
        KeyMaterial::resolve($config->jwtPublicKey);
        self::assertProfileSafety($config);
        self::assertKeyPathSafety($config->jwtPrivateKey, true, $config->appEnv);
        self::assertKeyPathSafety($config->jwtPublicKey, false, $config->appEnv);

        if (array_keys(MiddlewareOrder::GLOBAL_CLASS_MAP) !== MiddlewareOrder::GLOBAL) {
            throw new \RuntimeException('Global middleware order does not match contract.');
        }

        self::writeEvidence($config, $started);
    }

    private static function assertProfileSafety(RuntimeConfig $config): void
    {
        if ($config->appEnv === 'prod' && in_array('*', $config->corsAllowedOrigins, true)) {
            throw new \RuntimeException('config_disallowed_profile: wildcard CORS not allowed in prod');
        }

        if (in_array($config->appEnv, ['stage', 'prod'], true) && !str_starts_with(strtolower($config->jwtIssuer), 'https://')) {
            throw new \RuntimeException('config_disallowed_profile: stage/prod JWT_ISSUER must be https');
        }
    }

    private static function assertKeyPathSafety(string $keySource, bool $private, string $appEnv): void
    {
        if (str_starts_with($keySource, '-----BEGIN')) {
            return;
        }

        if (!is_file($keySource) || !is_readable($keySource)) {
            throw new \RuntimeException('config_invalid_format: key path is not readable');
        }

        if (!$private) {
            return;
        }

        $perms = @fileperms($keySource);
        if ($perms === false) {
            throw new \RuntimeException('config_invalid_format: key path permissions are unreadable');
        }

        if (in_array($appEnv, ['stage', 'prod'], true) && ($perms & 0o077) !== 0) {
            throw new \RuntimeException('config_disallowed_profile: private key permissions must be 600/400');
        }
    }

    private static function writeEvidence(RuntimeConfig $config, float $started): void
    {
        $path = getenv('BOOT_EVIDENCE_PATH');
        if (!is_string($path) || trim($path) === '') {
            return;
        }

        $payload = [
            'status' => 'ok',
            'timestamp_utc' => gmdate('c'),
            'app_env' => $config->appEnv,
            'middleware_order' => MiddlewareOrder::GLOBAL,
            'latency_ms' => (int) round((microtime(true) - $started) * 1000),
            'key_sources' => [
                'private' => str_starts_with($config->jwtPrivateKey, '-----BEGIN') ? 'inline_pem' : 'path',
                'public' => str_starts_with($config->jwtPublicKey, '-----BEGIN') ? 'inline_pem' : 'path',
            ],
        ];

        $encoded = json_encode($payload, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        if (@file_put_contents($path, $encoded) === false) {
            throw new \RuntimeException('boot_evidence_write_failed');
        }
    }
}
