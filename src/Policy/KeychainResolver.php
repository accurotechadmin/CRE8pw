<?php

declare(strict_types=1);

namespace Cre8\Policy;

final class KeychainResolver
{
    /**
     * @param array<int,array<string,mixed>> $grants
     * @return array{outcome:'Allow'|'Deny',reason_code:string,effective_permissions:array<int,string>,decision_path:array<int,string>}
     */
    public function resolve(string $principalType, string $requestedPermission, array $grants, array $contextConstraints = []): array
    {
        if (!PrincipalTaxonomy::isKnown($principalType)) {
            return $this->deny('AUTH_POLICY_UNRESOLVED', []);
        }

        $permission = PermissionVocabulary::normalize($requestedPermission);
        if ($permission === null) {
            return $this->deny('AUTH_DENY_PERMISSION_UNKNOWN', [$principalType]);
        }

        $eligible = array_values(array_filter($grants, static function (array $grant): bool {
            return ($grant['lifecycle_state'] ?? '') === 'active'
                && (($grant['expires_at_utc'] ?? '') === '' || strtotime((string) $grant['expires_at_utc']) >= time());
        }));

        usort($eligible, static function (array $a, array $b): int {
            $issuedA = strtotime((string) ($a['issued_at'] ?? '')) ?: 0;
            $issuedB = strtotime((string) ($b['issued_at'] ?? '')) ?: 0;
            if ($issuedA !== $issuedB) {
                return $issuedB <=> $issuedA;
            }
            return strcmp((string) ($a['grant_id'] ?? ''), (string) ($b['grant_id'] ?? ''));
        });

        if ($eligible === []) {
            return $this->deny('AUTH_DENY_DELEGATION_SCOPE', [$principalType]);
        }

        $effective = [];
        $path = [$principalType];
        foreach ($eligible as $grant) {
            $path[] = (string) ($grant['grant_id'] ?? '');
            foreach (($grant['permissions'] ?? []) as $token) {
                $normalized = PermissionVocabulary::normalize((string) $token);
                if ($normalized !== null && !in_array($normalized, $effective, true)) {
                    $effective[] = $normalized;
                }
            }
        }

        if (($contextConstraints['scope_match'] ?? true) !== true) {
            return $this->deny('AUTH_SCOPE_DENIED', $path, $effective);
        }

        if (!in_array($permission, $effective, true)) {
            return $this->deny('AUTH_PERMISSION_DENIED', $path, $effective);
        }

        return ['outcome' => 'Allow', 'reason_code' => 'OK', 'effective_permissions' => [$permission], 'decision_path' => $path];
    }

    private function deny(string $reason, array $path, array $effective = []): array
    {
        return ['outcome' => 'Deny', 'reason_code' => $reason, 'effective_permissions' => $effective, 'decision_path' => $path];
    }
}
