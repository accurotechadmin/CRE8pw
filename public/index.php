<?php

declare(strict_types=1);

use Cre8\Bootstrap\AppFactory;
use Cre8\Bootstrap\BootChecks;
use Cre8\Bootstrap\ContainerFactory;
use Cre8\Config\RuntimeConfig;
use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

/**
 * @return array<string, string|false>
 */
function loadRuntimeEnv(): array
{
    $env = $_ENV + $_SERVER;

    $requiredKeys = [
        'APP_ENV',
        'DB_DSN',
        'DB_USER',
        'DB_PASS',
        'JWT_ISSUER',
        'JWT_AUDIENCE_CONSOLE',
        'JWT_AUDIENCE_GATEWAY',
        'JWT_PRIVATE_KEY',
        'JWT_PUBLIC_KEY',
        'CORS_ALLOWED_ORIGINS',
        'CSRF_SECRET',
        'RATE_LIMIT_GLOBAL_ID',
        'RATE_LIMIT_GLOBAL_POLICY',
        'RATE_LIMIT_GLOBAL_INTERVAL',
        'RATE_LIMIT_GLOBAL_LIMIT',
        'JWT_OWNER_TTL_SECONDS',
        'JWT_KEY_TTL_SECONDS',
        'JWT_DELEGATION_TTL_SECONDS',
    ];

    foreach ($requiredKeys as $key) {
        if (($env[$key] ?? false) !== false) {
            continue;
        }

        $value = getenv($key);
        if ($value !== false) {
            $env[$key] = $value;
        }
    }

    $projectRoot = dirname(__DIR__);
    foreach (['JWT_PRIVATE_KEY', 'JWT_PUBLIC_KEY'] as $jwtKey) {
        $value = $env[$jwtKey] ?? false;
        if ($value === false) {
            continue;
        }

        $trimmed = trim((string) $value);
        if ($trimmed === '' || str_starts_with($trimmed, '-----BEGIN')) {
            $env[$jwtKey] = $trimmed;
            continue;
        }

        if (str_starts_with($trimmed, '/')) {
            $env[$jwtKey] = $trimmed;
            continue;
        }

        $env[$jwtKey] = $projectRoot.'/'.$trimmed;
    }

    return $env;
}

try {
    Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

    $config = RuntimeConfig::fromEnv(loadRuntimeEnv());
    $container = ContainerFactory::build($config);
    BootChecks::assert($container, $config);

    error_log((string) json_encode([
        'event' => 'boot.startup_ready',
        'timestamp_utc' => gmdate('c'),
        'app_env' => $config->appEnv,
        'outcome' => 'ok',
    ], JSON_THROW_ON_ERROR));

    $app = AppFactory::create($container);
    $app->run();
} catch (\Throwable $e) {
    $requestId = bin2hex(random_bytes(8));
    error_log((string) json_encode([
        'event' => 'boot.startup_failed',
        'timestamp_utc' => gmdate('c'),
        'outcome' => 'error',
        'request_id' => $requestId,
        'error_class' => $e::class,
        'error_message' => $e->getMessage(),
    ], JSON_THROW_ON_ERROR));

    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Request-Id: ' . $requestId);
    echo (string) json_encode([
        'error' => [
            'code' => 'boot_failed',
            'message' => 'application startup failed',
            'details' => [],
            'request_id' => $requestId,
        ],
        'meta' => [
            'timestamp_utc' => gmdate('c'),
            'request_id' => $requestId,
        ],
    ], JSON_THROW_ON_ERROR);
}