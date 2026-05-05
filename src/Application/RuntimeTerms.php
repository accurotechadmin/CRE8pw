<?php

declare(strict_types=1);

namespace Cre8\Application;

final class RuntimeTerms
{
    private const ALLOW = 'Allow';
    private const DENY = 'Deny';

    public static function allow(): string { return self::ALLOW; }
    public static function deny(): string { return self::DENY; }
}
