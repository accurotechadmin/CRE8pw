<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Application\UseCases;

use Cre8\Modules\Auth\Domain\Policies\KeyCredentialPolicy;
use Cre8\Modules\Auth\Domain\Policies\TokenSurfacePolicy;

final class LoginKey
{
    public function __construct(
        private readonly KeyCredentialPolicy $credentialPolicy,
        private readonly TokenSurfacePolicy $tokenPolicy
    ) {
    }

    /**
     * @return array{access_token:string,refresh_token:string,expires_in:int}
     */
    public function execute(string $keyId, string $apiKey): array
    {
        if (!$this->credentialPolicy->isValid($keyId, $apiKey)) {
            throw new KeyAuthenticationFailed();
        }

        return $this->tokenPolicy->issueKeyTokens($keyId);
    }
}
