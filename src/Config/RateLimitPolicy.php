<?php

declare(strict_types=1);

namespace Cre8\Config;

final class RateLimitPolicy
{
    public function __construct(
        public readonly string $id = 'global',
        public readonly string $policy = 'fixed_window',
        public readonly string $interval = '1 minute',
        public readonly int $limit = 180,
    ) {
    }
}
