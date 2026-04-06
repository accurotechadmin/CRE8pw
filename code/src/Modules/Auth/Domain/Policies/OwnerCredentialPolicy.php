<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Domain\Policies;

final class OwnerCredentialPolicy
{
    /**
     * @param array<string,string> $ownersByEmail
     */
    public function __construct(private readonly array $ownersByEmail)
    {
    }

    public function isValid(string $email, string $password): bool
    {
        return isset($this->ownersByEmail[$email])
            && hash_equals($this->ownersByEmail[$email], $password);
    }
}
