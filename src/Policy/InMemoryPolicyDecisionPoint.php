<?php

declare(strict_types=1);

namespace Cre8\Policy;

final class InMemoryPolicyDecisionPoint implements PolicyDecisionPointInterface
{
    public function decide(array $evaluationContext): array
    {
        return ['outcome' => 'Deny', 'reason_code' => 'AUTH_DENY_NOT_IMPLEMENTED'];
    }
}
