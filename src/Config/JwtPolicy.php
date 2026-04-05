<?php

declare(strict_types=1);

namespace Cre8\Config;

final class JwtPolicy
{
    public function __construct(
        public readonly int $ownerTtlSeconds = 900,
        public readonly int $keyTtlSeconds = 600,
        public readonly int $delegationTtlSeconds = 300,
    ) {
    }
}
