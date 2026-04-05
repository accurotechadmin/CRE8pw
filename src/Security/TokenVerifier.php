<?php

declare(strict_types=1);

namespace Cre8\Security;

interface TokenVerifier
{
    public function verify(string $token): TokenVerificationResult;
}
