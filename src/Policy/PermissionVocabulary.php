<?php

declare(strict_types=1);

namespace Cre8\Policy;

final class PermissionVocabulary
{
    /** @var array<string,string> */
    private const ALIASES = [
        'authz.decide' => 'authz.decision.invoke',
        'principal.create' => 'principal.actor.create',
        'post.create' => 'content.post.create',
        'post.read' => 'content.post.read',
    ];

    public static function normalize(string $token): ?string
    {
        if (isset(self::ALIASES[$token])) {
            return self::ALIASES[$token];
        }

        return self::isCanonicalShape($token) ? $token : null;
    }

    public static function isCanonicalShape(string $token): bool
    {
        return preg_match('/^[a-z0-9]+(\.[a-z0-9_]+){2,}$/', $token) === 1;
    }
}
