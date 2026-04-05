<?php

declare(strict_types=1);

namespace Cre8\Security;

final class TokenVerificationResult
{
    /**
     * @param array<string,mixed> $claims
     * @param list<string> $policyViolations
     */
    public function __construct(
        public readonly array $claims,
        public readonly VerifiedPrincipal $principal,
        public readonly array $policyViolations = [],
    ) {
    }
}
