<?php

declare(strict_types=1);

namespace Cre8\Policy;

final class PrincipalTaxonomy
{
    private const TYPES = ['ROOT_ADMIN', 'TENANT_ADMIN', 'IDENTITY_OPERATOR', 'UTILITY_AGENT', 'DELEGATEE'];

    public static function isKnown(string $type): bool
    {
        return in_array($type, self::TYPES, true);
    }
}
