<?php

declare(strict_types=1);

namespace Cre8\Tests\Security;

use Cre8\Security\ApiKeyHasher;
use PHPUnit\Framework\TestCase;

final class ApiKeyHasherSecurityTest extends TestCase
{
    public function testHasherSupportsPolicyConfigurableArgonParametersAndVerification(): void
    {
        $hasher = new ApiKeyHasher(
            opsLimit: SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            memLimit: SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
        );

        $hash = $hasher->hash('cre8-secret-api-key');

        self::assertTrue($hasher->verify('cre8-secret-api-key', $hash));
        self::assertFalse($hasher->verify('wrong', $hash));
    }

    public function testHasherReturnsRotationMetadataAlongsideHashMaterial(): void
    {
        $hasher = new ApiKeyHasher();

        $metadata = $hasher->hashWithMetadata(
            'cre8-secret-api-key',
            keyVersion: 'key-v3',
            rotatedAtUtc: '2026-04-04T00:00:00Z',
        );

        self::assertSame('argon2id', $metadata['algorithm']);
        self::assertSame('key-v3', $metadata['key_version']);
        self::assertSame('2026-04-04T00:00:00Z', $metadata['rotated_at_utc']);
        self::assertTrue($hasher->verify('cre8-secret-api-key', $metadata['hash']));
    }

    public function testHasherVerificationHandlesMalformedHashUsingTimingSafeFallbackPath(): void
    {
        $hasher = new ApiKeyHasher();

        self::assertFalse($hasher->verify('cre8-secret-api-key', ''));
        self::assertFalse($hasher->verify('cre8-secret-api-key', 'not-an-argon-hash'));
    }
}

