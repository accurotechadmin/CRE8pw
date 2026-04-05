<?php

declare(strict_types=1);

namespace Cre8\Tests\Security;

use Cre8\Config\RuntimeConfig;
use Cre8\Security\JwtTokenSigner;
use Cre8\Security\JwtTokenVerifier;
use Cre8\Security\TokenValidationException;
use PHPUnit\Framework\TestCase;

final class JwtTokenSecurityTest extends TestCase
{
    public function testSignerProducesOwnerKeyAndDelegationTokensWithKidHeader(): void
    {
        $signer = new JwtTokenSigner($this->config());
        $verifier = new JwtTokenVerifier($this->config());

        $owner = $signer->sign(['sub' => 'owner_1', 'typ' => 'owner', 'aud' => 'console']);
        $key = $signer->sign(['sub' => 'key_1', 'typ' => 'key', 'aud' => 'gateway']);
        $delegation = $signer->sign([
            'sub' => 'delegation_1',
            'typ' => 'delegation',
            'aud' => 'gateway',
            'delegation_envelope_id' => 'env_123',
            'initial_author_key_id' => 'aauth_0123456789abcdef0123456789abcdef',
        ]);

        self::assertSame('owner', $verifier->verify($owner)->principal->type);
        self::assertSame('key', $verifier->verify($key)->principal->type);
        $delegationClaims = $verifier->verify($delegation);
        self::assertSame('delegation', $delegationClaims->principal->type);
        self::assertNotSame('', (string) ($delegationClaims->claims['jti'] ?? ''));

        self::assertNotSame('', $this->tokenHeaderKid($owner));
        self::assertNotSame('', $this->tokenHeaderKid($key));
        self::assertNotSame('', $this->tokenHeaderKid($delegation));
    }

    public function testSignerRejectsMissingRequiredClaims(): void
    {
        $signer = new JwtTokenSigner($this->config());

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_claims');
        $signer->sign(['typ' => 'owner', 'aud' => 'console']);
    }

    public function testVerifierRejectsInvalidAudienceTypeMapping(): void
    {
        $signer = new JwtTokenSigner($this->config());
        $verifier = new JwtTokenVerifier($this->config());
        $token = $signer->sign(['sub' => 'owner_1', 'typ' => 'owner', 'aud' => 'console']);
        $tampered = $this->rewriteClaim($token, 'aud', 'gateway');

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_claims');
        $verifier->verify($tampered);
    }


    public function testSignerRejectsDelegationTokenWithoutLineageClaims(): void
    {
        $signer = new JwtTokenSigner($this->config());

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_claims');
        $signer->sign(['sub' => 'delegation_1', 'typ' => 'delegation', 'aud' => 'gateway']);
    }

    public function testVerifierRejectsTokensExceedingPolicyTtl(): void
    {
        $signer = new JwtTokenSigner($this->config());
        $verifier = new JwtTokenVerifier($this->config());
        $token = $signer->sign([
            'sub' => 'owner_1',
            'typ' => 'owner',
            'aud' => 'console',
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 1900,
        ]);

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_claims');
        $verifier->verify($token);
    }

    public function testVerifierRejectsInvalidSignature(): void
    {
        $verifier = new JwtTokenVerifier($this->config());

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_signature');
        $verifier->verify('not-a-jwt-token');
    }

    private function config(): RuntimeConfig
    {
        if (!function_exists('openssl_pkey_new')) {
            self::markTestSkipped('openssl extension is required for JWT crypto tests');
        }

        $resource = openssl_pkey_new([
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'private_key_bits' => 2048,
        ]);
        self::assertNotFalse($resource);

        openssl_pkey_export($resource, $privateKey);
        $details = openssl_pkey_get_details($resource);
        self::assertIsArray($details);
        $publicKey = (string) ($details['key'] ?? '');
        self::assertNotSame('', $privateKey);
        self::assertNotSame('', $publicKey);

        return new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: 'u',
            dbPass: 'p',
            jwtIssuer: 'https://cre8.test',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $privateKey,
            jwtPublicKey: $publicKey,
            corsAllowedOrigins: ['http://localhost:3000'],
            csrfSecret: str_repeat('x', 32),
        );
    }

    private function tokenHeaderKid(string $token): string
    {
        $parts = explode('.', $token);
        $header = json_decode((string) base64_decode(strtr($parts[0] ?? '', '-_', '+/')), true);

        return (string) ($header['kid'] ?? '');
    }

    private function rewriteClaim(string $token, string $claim, string $value): string
    {
        $parts = explode('.', $token);
        $payload = json_decode((string) base64_decode(strtr($parts[1] ?? '', '-_', '+/')), true);
        $payload[$claim] = $value;
        $parts[1] = rtrim(strtr(base64_encode((string) json_encode($payload)), '+/', '-_'), '=');

        return implode('.', $parts);
    }
}
