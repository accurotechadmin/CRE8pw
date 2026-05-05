<?php

declare(strict_types=1);

namespace Cre8\Policy;

interface PolicyDecisionPointInterface
{
    /**
     * @param array<string,mixed> $evaluationContext
     * @return array{outcome:'Allow'|'Deny',reason_code?:string}
     */
    public function decide(array $evaluationContext): array;
}
