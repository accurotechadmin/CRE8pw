<?php

declare(strict_types=1);

namespace Cre8\Security;

use Cre8\Config\RuntimeConfig;
use Firebase\JWT\JWT;

final class JwtTokenSigner implements TokenSigner
{
    private string $privateKey;
    private string $publicKey;
    private string $kid;

    public function __construct(private readonly RuntimeConfig $config)
    {
        $this->privateKey = KeyMaterial::resolve($this->config->jwtPrivateKey);
        $this->publicKey = KeyMaterial::resolve($this->config->jwtPublicKey);
        $this->kid = substr(hash('sha256', $this->publicKey), 0, 16);
    }

    public function sign(array $claims, string $tokenClass = 'access', array $context = [], ?int $expiresInSeconds = null): string
    {
        $tokenType = $this->requiredString($claims, 'typ');
        $subject = $this->requiredString($claims, 'sub');
        $audience = $this->requiredString($claims, 'aud');

        if (!in_array($tokenType, ['owner', 'key', 'delegation'], true)) {
            throw new TokenValidationException('token_invalid_claims: unsupported typ');
        }

        if (strlen($subject) < 3) {
            throw new TokenValidationException('token_invalid_claims: subject too short');
        }

        $this->assertAudienceMatchesTokenType($tokenType, $audience);
        $this->assertDelegationClaims($tokenType, $claims);

        $now = time();
        $iat = isset($claims['iat']) ? (int) $claims['iat'] : $now;
        $nbf = isset($claims['nbf']) ? (int) $claims['nbf'] : $iat;
        $exp = isset($claims['exp']) ? (int) $claims['exp'] : $now + ($expiresInSeconds ?? $this->defaultTtlSeconds($tokenType));

        if ($iat > $now + 60) {
            throw new TokenValidationException('token_invalid_claims: iat cannot be in the far future');
        }

        if ($nbf < $iat - 60 || $nbf > $exp) {
            throw new TokenValidationException('token_invalid_claims: nbf must be within token validity window');
        }

        if ($exp <= $now) {
            throw new TokenValidationException('token_invalid_claims: exp must be in the future');
        }

        $ttl = $exp - $iat;
        if ($ttl <= 0 || $ttl > $this->maxTtlSeconds($tokenType)) {
            throw new TokenValidationException('token_invalid_claims: exp window exceeds policy for token type');
        }

        $payload = array_merge([
            'iss' => $this->config->jwtIssuer,
            'iat' => $iat,
            'nbf' => $nbf,
            'exp' => $exp,
            'jti' => bin2hex(random_bytes(16)),
            'token_class' => $tokenClass,
        ], $claims);

        if ($context !== []) {
            $payload['ctx'] = $context;
        }

        return JWT::encode($payload, $this->privateKey, 'RS256', $this->kid);
    }

    /** @param array<string,mixed> $claims */
    private function requiredString(array $claims, string $field): string
    {
        $value = trim((string) ($claims[$field] ?? ''));
        if ($value === '') {
            throw new TokenValidationException("token_invalid_claims: {$field} is required");
        }

        return $value;
    }

    private function assertAudienceMatchesTokenType(string $tokenType, string $audience): void
    {
        if ($tokenType === 'owner' && $audience !== $this->config->jwtAudienceConsole) {
            throw new TokenValidationException('token_invalid_claims: owner token must target console audience');
        }

        if (in_array($tokenType, ['key', 'delegation'], true) && $audience !== $this->config->jwtAudienceGateway) {
            throw new TokenValidationException('token_invalid_claims: key/delegation token must target gateway audience');
        }
    }

    /** @param array<string,mixed> $claims */
    private function assertDelegationClaims(string $tokenType, array $claims): void
    {
        if ($tokenType !== 'delegation') {
            return;
        }

        foreach (['delegation_envelope_id', 'initial_author_key_id'] as $field) {
            if (trim((string) ($claims[$field] ?? '')) === '') {
                throw new TokenValidationException("token_invalid_claims: {$field} is required for delegation token");
            }
        }
    }

    private function defaultTtlSeconds(string $tokenType): int
    {
        return match ($tokenType) {
            'owner' => 900,
            'key' => 600,
            'delegation' => 300,
            default => 900,
        };
    }

    private function maxTtlSeconds(string $tokenType): int
    {
        return match ($tokenType) {
            'owner' => 900,
            'key' => 600,
            'delegation' => 3600,
            default => 900,
        };
    }
}
