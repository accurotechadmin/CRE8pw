<?php

declare(strict_types=1);

namespace Cre8\Config;

final class CorsPolicy
{
    /** @param list<string> $allowedOrigins */
    public function __construct(
        public readonly array $allowedOrigins,
        public readonly bool $allowWildcard = false,
    ) {
    }
}
