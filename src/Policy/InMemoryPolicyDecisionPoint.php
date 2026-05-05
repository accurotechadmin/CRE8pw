<?php

declare(strict_types=1);

namespace Cre8\Policy;

use Cre8\Application\RuntimeTerms;

final class InMemoryPolicyDecisionPoint implements PolicyDecisionPointInterface
{
    public function decide(array $evaluationContext): array
    {
        $principalType = (string) ($evaluationContext['principal_type'] ?? '');
        if ($principalType === '' || !PrincipalTaxonomy::isKnown($principalType)) {
            return ['outcome' => RuntimeTerms::deny(), 'reason_code' => 'AUTH_POLICY_UNRESOLVED', 'evaluated_gate' => 0];
        }

        $permission = PermissionVocabulary::normalize((string) ($evaluationContext['required_permission'] ?? ''));
        if ($permission === null) {
            return ['outcome' => RuntimeTerms::deny(), 'reason_code' => 'AUTH_DENY_PERMISSION_UNKNOWN', 'evaluated_gate' => 5];
        }

        $gates = [
            1 => ['lifecycle_state', static fn ($v): bool => $v === 'active', 'AUTH_LIFECYCLE_BLOCKED'],
            2 => ['credential_valid', static fn ($v): bool => $v === true, 'AUTH_CREDENTIAL_INVALID'],
            3 => ['explicit_deny', static fn ($v): bool => $v !== true, 'AUTH_EXPLICIT_DENY'],
            4 => ['scope_match', static fn ($v): bool => $v === true, 'AUTH_SCOPE_DENIED'],
            5 => ['permission_match', static fn ($v): bool => $v === true, 'AUTH_PERMISSION_DENIED'],
            6 => ['depth_ok', static fn ($v): bool => $v === true, 'AUTH_DEPTH_EXCEEDED'],
            7 => ['not_expired', static fn ($v): bool => $v === true, 'AUTH_GRANT_EXPIRED'],
        ];

        foreach ($gates as $idx => [$key, $check, $reason]) {
            if (!$check($evaluationContext[$key] ?? null)) {
                return ['outcome' => RuntimeTerms::deny(), 'reason_code' => $reason, 'evaluated_gate' => $idx];
            }
        }

        return ['outcome' => RuntimeTerms::allow(), 'reason_code' => 'OK', 'evaluated_gate' => 7, 'required_permission' => $permission];
    }
}
