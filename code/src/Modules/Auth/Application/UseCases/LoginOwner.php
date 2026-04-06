<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Application\UseCases;

use Cre8\Modules\Auth\Domain\Policies\OwnerCredentialPolicy;
use Cre8\Modules\Auth\Domain\Policies\TokenSurfacePolicy;

final class LoginOwner
{
    public function __construct(
        private readonly OwnerCredentialPolicy $credentialPolicy,
        private readonly TokenSurfacePolicy $tokenPolicy
    ) {
    }

    /**
     * @return array{access_token:string,refresh_token:string,expires_in:int}
     */
    public function execute(string $email, string $password): array
    {
        if (!$this->credentialPolicy->isValid($email, $password)) {
            throw new OwnerAuthenticationFailed();
        }

        return $this->tokenPolicy->issueOwnerTokens($email);
    }
}
