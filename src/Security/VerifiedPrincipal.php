<?php

declare(strict_types=1);

namespace Cre8\Security;

final class VerifiedPrincipal
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $audience,
        public readonly ?string $keyClass = null,
    ) {
    }
}
