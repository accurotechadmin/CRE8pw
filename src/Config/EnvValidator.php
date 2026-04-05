<?php

declare(strict_types=1);

namespace Cre8\Config;

final class EnvValidator
{
    /** @param array<string, string|false> $env */
    public static function validateRequired(array $env): void
    {
        $required = [
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
        ];

        $missing = [];
        foreach ($required as $name) {
            $value = $env[$name] ?? false;
            if ($value === false || trim((string) $value) === '') {
                $missing[] = $name;
            }
        }

        if ($missing !== []) {
            throw new \RuntimeException('config_missing_required: '.implode(', ', $missing));
        }

        $appEnv = (string) ($env['APP_ENV'] ?? '');
        if (!in_array($appEnv, ['local', 'stage', 'prod'], true)) {
            throw new \RuntimeException('config_disallowed_profile: APP_ENV must be local|stage|prod');
        }

        if (strlen((string) $env['CSRF_SECRET']) < 32) {
            throw new \RuntimeException('config_invalid_format: CSRF_SECRET must be >= 32 chars');
        }

        $origins = array_filter(array_map('trim', explode(',', (string) $env['CORS_ALLOWED_ORIGINS'])));
        if ($origins === []) {
            throw new \RuntimeException('config_invalid_format: CORS_ALLOWED_ORIGINS must include at least one origin');
        }

        if (in_array('*', $origins, true) && $appEnv !== 'local') {
            throw new \RuntimeException('config_disallowed_profile: wildcard CORS only allowed in local');
        }

        $dsn = (string) $env['DB_DSN'];
        if (!preg_match('/^(sqlite:|mysql:|pgsql:)/', $dsn)) {
            throw new \RuntimeException('config_invalid_format: DB_DSN must use sqlite|mysql|pgsql driver prefix');
        }

        if ($appEnv === 'prod' && str_starts_with($dsn, 'sqlite:')) {
            throw new \RuntimeException('config_disallowed_profile: prod cannot use sqlite DSN');
        }

        $issuer = (string) $env['JWT_ISSUER'];
        if ($issuer === '' || filter_var($issuer, FILTER_VALIDATE_URL) === false) {
            throw new \RuntimeException('config_invalid_format: JWT_ISSUER must be a valid URL');
        }

        if (in_array($appEnv, ['stage', 'prod'], true) && !str_starts_with(strtolower($issuer), 'https://')) {
            throw new \RuntimeException('config_disallowed_profile: stage/prod JWT_ISSUER must be https');
        }

        self::validateKeySource((string) $env['JWT_PRIVATE_KEY'], 'JWT_PRIVATE_KEY');
        self::validateKeySource((string) $env['JWT_PUBLIC_KEY'], 'JWT_PUBLIC_KEY');
        self::validateOptionalPositiveInt($env, 'RATE_LIMIT_GLOBAL_LIMIT');
        self::validateOptionalPositiveInt($env, 'JWT_OWNER_TTL_SECONDS');
        self::validateOptionalPositiveInt($env, 'JWT_KEY_TTL_SECONDS');
        self::validateOptionalPositiveInt($env, 'JWT_DELEGATION_TTL_SECONDS');
    }

    private static function validateKeySource(string $value, string $name): void
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            throw new \RuntimeException("config_missing_required: {$name}");
        }

        if (str_starts_with($trimmed, '-----BEGIN')) {
            if (!str_contains($trimmed, '-----END')) {
                throw new \RuntimeException("config_invalid_format: {$name} PEM must include END marker");
            }

            return;
        }

        if (!preg_match('/^[\\w\\.\\/-]+$/', $trimmed)) {
            throw new \RuntimeException("config_invalid_format: {$name} path contains unsupported characters");
        }
    }

    /** @param array<string, string|false> $env */
    private static function validateOptionalPositiveInt(array $env, string $key): void
    {
        $value = $env[$key] ?? false;
        if ($value === false || trim((string) $value) === '') {
            return;
        }

        if (!ctype_digit((string) $value) || (int) $value <= 0) {
            throw new \RuntimeException("config_invalid_format: {$key} must be a positive integer");
        }
    }
}
