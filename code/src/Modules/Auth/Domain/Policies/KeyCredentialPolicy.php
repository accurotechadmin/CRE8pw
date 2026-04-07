<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Domain\Policies;

final class KeyCredentialPolicy
{
    /**
     * @param array<string,string> $apiKeysByKeyId
     */
    public function __construct(private readonly array $apiKeysByKeyId)
    {
    }

    public function isValid(string $keyId, string $apiKey): bool
    {
        return isset($this->apiKeysByKeyId[$keyId])
            && hash_equals($this->apiKeysByKeyId[$keyId], $apiKey);
    }
}
