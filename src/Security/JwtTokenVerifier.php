<?php

declare(strict_types=1);

namespace Cre8\Security;

use Cre8\Config\RuntimeConfig;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

final class JwtTokenVerifier implements TokenVerifier
{
    private const CLOCK_SKEW_SECONDS = 60;

    private string $publicKey;

    public function __construct(private readonly RuntimeConfig $config)
    {
        $this->publicKey = KeyMaterial::resolve($this->config->jwtPublicKey);
    }

    public function verify(string $token): TokenVerificationResult
    {
        $previousLeeway = JWT::$leeway;
        JWT::$leeway = self::CLOCK_SKEW_SECONDS;
        try {
            $decoded = JWT::decode($token, new Key($this->publicKey, 'RS256'));
        } catch (SignatureInvalidException $e) {
            throw new TokenValidationException('token_invalid_signature', 0, $e);
        } catch (\UnexpectedValueException $e) {
            throw new TokenValidationException('token_invalid_signature', 0, $e);
        } catch (\Throwable $e) {
            throw new TokenValidationException('token_invalid_claims', 0, $e);
        } finally {
            JWT::$leeway = $previousLeeway;
        }

        $claims = (array) $decoded;
        $this->assertRequiredClaims($claims);
        $this->assertIssuer($claims);
        $this->assertTemporalClaims($claims);
        $this->assertAudienceAndType($claims);
        $this->assertDelegationClaims($claims);

        return new TokenVerificationResult(
            claims: $claims,
            principal: new VerifiedPrincipal(
                id: (string) $claims['sub'],
                type: (string) $claims['typ'],
                audience: (string) $claims['aud'],
                keyClass: isset($claims['key_class']) ? (string) $claims['key_class'] : null,
            ),
            policyViolations: $this->policyViolations($claims),
        );
    }

    /** @param array<string, mixed> $claims */
    private function assertRequiredClaims(array $claims): void
    {
        foreach (['iss', 'aud', 'exp', 'nbf', 'iat', 'sub', 'typ', 'jti'] as $required) {
            if (!array_key_exists($required, $claims) || trim((string) $claims[$required]) === '') {
                throw new TokenValidationException('token_invalid_claims');
            }
        }
    }

    /** @param array<string, mixed> $claims */
    private function assertIssuer(array $claims): void
    {
        if ((string) $claims['iss'] !== $this->config->jwtIssuer) {
            throw new TokenValidationException('token_invalid_claims');
        }
    }

    /** @param array<string, mixed> $claims */
    private function assertTemporalClaims(array $claims): void
    {
        $iat = (int) $claims['iat'];
        $nbf = (int) $claims['nbf'];
        $exp = (int) $claims['exp'];
        $now = time();

        if ($iat > $now + self::CLOCK_SKEW_SECONDS) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if ($nbf > $exp || $nbf < $iat - self::CLOCK_SKEW_SECONDS) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if ($exp <= $now - self::CLOCK_SKEW_SECONDS) {
            throw new TokenValidationException('token_invalid_claims');
        }

        $ttl = $exp - $iat;
        if ($ttl <= 0) {
            throw new TokenValidationException('token_invalid_claims');
        }

        $maxTtl = $this->maxTtlSeconds((string) $claims['typ']);
        if ($ttl > $maxTtl) {
            throw new TokenValidationException('token_invalid_claims');
        }
    }

    /** @param array<string, mixed> $claims */
    private function assertAudienceAndType(array $claims): void
    {
        $audience = (string) $claims['aud'];
        $type = (string) $claims['typ'];

        if (!in_array($audience, [$this->config->jwtAudienceConsole, $this->config->jwtAudienceGateway], true)) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if ($type === 'owner' && $audience !== $this->config->jwtAudienceConsole) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if (in_array($type, ['key', 'delegation'], true) && $audience !== $this->config->jwtAudienceGateway) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if (!in_array($type, ['owner', 'key', 'delegation'], true)) {
            throw new TokenValidationException('token_invalid_claims');
        }
    }

    /** @param array<string, mixed> $claims */
    private function assertDelegationClaims(array $claims): void
    {
        if (($claims['typ'] ?? '') !== 'delegation') {
            return;
        }

        foreach (['delegation_envelope_id', 'initial_author_key_id'] as $required) {
            if (trim((string) ($claims[$required] ?? '')) === '') {
                throw new TokenValidationException('token_invalid_claims');
            }
        }
    }


    /** @param array<string,mixed> $claims
     *  @return list<string>
     */
    private function policyViolations(array $claims): array
    {
        $violations = [];

        if (($claims['typ'] ?? null) === 'owner' && ($claims['aud'] ?? null) !== $this->config->jwtAudienceConsole) {
            $violations[] = 'owner_wrong_audience';
        }

        if (in_array((string) ($claims['typ'] ?? ''), ['key', 'delegation'], true) && ($claims['aud'] ?? null) !== $this->config->jwtAudienceGateway) {
            $violations[] = 'key_wrong_audience';
        }

        return $violations;
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
