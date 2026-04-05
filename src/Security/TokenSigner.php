<?php

declare(strict_types=1);

namespace Cre8\Security;

interface TokenSigner
{
    /** @param array<string,mixed> $claims @param array<string,mixed> $context */
    public function sign(array $claims, string $tokenClass = 'access', array $context = [], ?int $expiresInSeconds = null): string;
}
