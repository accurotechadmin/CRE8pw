<?php

declare(strict_types=1);

namespace Cre8\Config;

final class RuntimeConfig
{
    /** @param list<string> $corsAllowedOrigins */
    public function __construct(
        public readonly string $appEnv,
        public readonly string $dbDsn,
        public readonly string $dbUser,
        public readonly string $dbPass,
        public readonly string $jwtIssuer,
        public readonly string $jwtAudienceConsole,
        public readonly string $jwtAudienceGateway,
        public readonly string $jwtPrivateKey,
        public readonly string $jwtPublicKey,
        public readonly array $corsAllowedOrigins,
        public readonly string $csrfSecret,
        public readonly ?RateLimitPolicy $rateLimitPolicy = null,
        public readonly ?CorsPolicy $corsPolicy = null,
        public readonly ?JwtPolicy $jwtPolicy = null,
    ) {
        $this->rateLimitPolicy ??= new RateLimitPolicy();
        $this->corsPolicy ??= new CorsPolicy($this->corsAllowedOrigins, !in_array('*', $this->corsAllowedOrigins, true));
        $this->jwtPolicy ??= new JwtPolicy();
    }

    /** @param array<string, string|false> $env */
    public static function fromEnv(array $env): self
    {
        EnvValidator::validateRequired($env);

        $origins = array_values(array_filter(array_map('trim', explode(',', self::envString($env, 'CORS_ALLOWED_ORIGINS')))));

        return new self(
            appEnv: self::envString($env, 'APP_ENV'),
            dbDsn: self::envString($env, 'DB_DSN'),
            dbUser: self::envString($env, 'DB_USER'),
            dbPass: self::envString($env, 'DB_PASS'),
            jwtIssuer: self::envString($env, 'JWT_ISSUER'),
            jwtAudienceConsole: self::envString($env, 'JWT_AUDIENCE_CONSOLE'),
            jwtAudienceGateway: self::envString($env, 'JWT_AUDIENCE_GATEWAY'),
            jwtPrivateKey: self::envString($env, 'JWT_PRIVATE_KEY'),
            jwtPublicKey: self::envString($env, 'JWT_PUBLIC_KEY'),
            corsAllowedOrigins: $origins,
            csrfSecret: self::envString($env, 'CSRF_SECRET'),
            rateLimitPolicy: new RateLimitPolicy(
                id: self::envString($env, 'RATE_LIMIT_GLOBAL_ID', 'global'),
                policy: self::envString($env, 'RATE_LIMIT_GLOBAL_POLICY', 'fixed_window'),
                interval: self::envString($env, 'RATE_LIMIT_GLOBAL_INTERVAL', '1 minute'),
                limit: max(1, (int) self::envString($env, 'RATE_LIMIT_GLOBAL_LIMIT', '180')),
            ),
            corsPolicy: new CorsPolicy(
                allowedOrigins: $origins,
                allowWildcard: in_array('*', $origins, true) && self::envString($env, 'APP_ENV') === 'local',
            ),
            jwtPolicy: new JwtPolicy(
                ownerTtlSeconds: max(1, (int) self::envString($env, 'JWT_OWNER_TTL_SECONDS', '900')),
                keyTtlSeconds: max(1, (int) self::envString($env, 'JWT_KEY_TTL_SECONDS', '600')),
                delegationTtlSeconds: max(1, (int) self::envString($env, 'JWT_DELEGATION_TTL_SECONDS', '300')),
            ),
        );
    }

    /** @param array<string, string|false> $env */
    private static function envString(array $env, string $key, string $default = ''): string
    {
        $value = $env[$key] ?? $default;
        if ($value === false) {
            return trim($default);
        }

        $trimmed = trim($value);
        return $trimmed === '' ? trim($default) : $trimmed;
    }
}