<?php

declare(strict_types=1);

namespace Cre8\Security;

final class ApiKeyHasher
{
    private string $dummyHash;

    public function __construct(
        private readonly int $opsLimit = SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
        private readonly int $memLimit = SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
    ) {
        $this->dummyHash = sodium_crypto_pwhash_str('__cre8_dummy_key__', $this->opsLimit, $this->memLimit);
    }

    public function hash(string $plain): string
    {
        return sodium_crypto_pwhash_str($plain, $this->opsLimit, $this->memLimit);
    }

    public function verify(string $plain, string $hash): bool
    {
        if ($hash === '' || str_starts_with($hash, '$argon2id$') === false) {
            sodium_crypto_pwhash_str_verify($this->dummyHash, $plain);

            return false;
        }

        return sodium_crypto_pwhash_str_verify($hash, $plain);
    }

    /** @return array{hash:string,algorithm:string,ops_limit:int,mem_limit:int,key_version:string|null,rotated_at_utc:string|null} */
    public function hashWithMetadata(string $plain, ?string $keyVersion = null, ?string $rotatedAtUtc = null): array
    {
        return [
            'hash' => $this->hash($plain),
            'algorithm' => 'argon2id',
            'ops_limit' => $this->opsLimit,
            'mem_limit' => $this->memLimit,
            'key_version' => $keyVersion,
            'rotated_at_utc' => $rotatedAtUtc,
        ];
    }
}
