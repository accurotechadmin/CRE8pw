<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Domain\Policies;

final class TokenSurfacePolicy
{
    public function ownerAccessTokenTtlSeconds(): int
    {
        return 900;
    }

    public function keyAccessTokenTtlSeconds(): int
    {
        return 600;
    }

    /**
     * @return array{access_token:string,refresh_token:string,expires_in:int}
     */
    public function issueOwnerTokens(string $subject): array
    {
        $accessEntropy = random_bytes(24);
        $refreshEntropy = random_bytes(24);

        return [
            'access_token' => rtrim(strtr(base64_encode($subject . '|' . $accessEntropy), '+/', '-_'), '='),
            'refresh_token' => rtrim(strtr(base64_encode($subject . '|refresh|' . $refreshEntropy), '+/', '-_'), '='),
            'expires_in' => $this->ownerAccessTokenTtlSeconds(),
        ];
    }

    /**
     * @return array{access_token:string,refresh_token:string,expires_in:int}
     */
    public function issueKeyTokens(string $keyId): array
    {
        $accessEntropy = random_bytes(24);
        $refreshEntropy = random_bytes(24);

        return [
            'access_token' => rtrim(strtr(base64_encode($keyId . '|' . $accessEntropy), '+/', '-_'), '='),
            'refresh_token' => rtrim(strtr(base64_encode($keyId . '|refresh|' . $refreshEntropy), '+/', '-_'), '='),
            'expires_in' => $this->keyAccessTokenTtlSeconds(),
        ];
    }
}
