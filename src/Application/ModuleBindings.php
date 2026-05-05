<?php

declare(strict_types=1);

namespace Cre8\Application;

use Cre8\Policy\InMemoryPolicyDecisionPoint;
use Cre8\Policy\PolicyDecisionPointInterface;

final class ModuleBindings
{
    /** @return array<class-string,class-string> */
    public static function definitions(): array
    {
        return [
            PolicyDecisionPointInterface::class => InMemoryPolicyDecisionPoint::class,
        ];
    }
}
