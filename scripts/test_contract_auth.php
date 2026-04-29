<?php

declare(strict_types=1);

$decisionTablePath = dirname(__DIR__) . '/docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md';
$delegationSpecPath = dirname(__DIR__) . '/docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md';
$openapiPath = dirname(__DIR__) . '/docs/31_machine_contracts/openapi/cre8.v1.yaml';

$decisionTable = file_get_contents($decisionTablePath);
$delegationSpec = file_get_contents($delegationSpecPath);
$openapi = file_get_contents($openapiPath);
if ($decisionTable === false || $delegationSpec === false || $openapi === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-POLICY-ORDER] unable to read authorization contract docs" . PHP_EOL);
    exit(1);
}

$expected = [
    1 => 'AUTH_LIFECYCLE_BLOCKED',
    2 => 'AUTH_CREDENTIAL_INVALID',
    3 => 'AUTH_EXPLICIT_DENY',
    4 => 'AUTH_SCOPE_DENIED',
    5 => 'AUTH_PERMISSION_DENIED',
    6 => 'AUTH_DEPTH_EXCEEDED',
    7 => 'AUTH_GRANT_EXPIRED',
];

$found = [];
foreach (explode("\n", $decisionTable) as $line) {
    if (preg_match('/^\|\s*([0-9]+)\s*\|[^|]*\|[^|]*\|[^|]*\|\s*`([A-Z0-9_]+)`\s*\|/', trim($line), $m) === 1) {
        $found[(int)$m[1]] = $m[2];
    }
}

$errors = [];
foreach ($expected as $step => $reason) {
    if (!isset($found[$step])) {
        $errors[] = "[HOOK-CONTRACT-POLICY-ORDER] missing decision-table step {$step}";
        continue;
    }
    if ($found[$step] !== $reason) {
        $errors[] = "[HOOK-CONTRACT-POLICY-ORDER] step {$step} expected {$reason}, found {$found[$step]}";
    }
}

if (count($found) !== count($expected)) {
    $errors[] = '[HOOK-CONTRACT-POLICY-ORDER] decision-table step count drift detected';
}

$inheritanceClause = 'Descendant grants **MUST NOT** include permissions, scopes, lifecycle durations, or delegation depth beyond the effective limits of the delegating ancestor.';
if (!str_contains($delegationSpec, $inheritanceClause)) {
    $errors[] = '[HOOK-AUTH-INHERITANCE-BOUNDARY] CRE8-AUTH-REQ-0002 canonical inheritance-boundary clause drift detected';
}

$lifecycleClause = 'Credential lifecycle changes (`suspend`, `revoke`, `expire`) **MUST** be enforced on subsequent authorization decisions with no grace bypass path unless explicitly defined by normative emergency policy.';
if (!str_contains($delegationSpec, $lifecycleClause)) {
    $errors[] = '[HOOK-AUTH-LIFECYCLE-ENFORCEMENT] CRE8-AUTH-REQ-0006 lifecycle-enforcement clause drift detected';
}

if (!str_contains($delegationSpec, 'HOOK-AUTH-INHERITANCE-BOUNDARY')) {
    $errors[] = '[HOOK-AUTH-INHERITANCE-BOUNDARY] verification hook declaration missing from authorization spec';
}
if (!str_contains($delegationSpec, 'HOOK-AUTH-LIFECYCLE-ENFORCEMENT')) {
    $errors[] = '[HOOK-AUTH-LIFECYCLE-ENFORCEMENT] verification hook declaration missing from authorization spec';
}

if (!str_contains($openapi, '/v1/authz/decide:')) {
    $errors[] = '[HOOK-CONTRACT-POLICY-ORDER] missing /v1/authz/decide route in OpenAPI contract';
}
if (!str_contains($openapi, 'interactionLifecycleBlocked:')) {
    $errors[] = '[HOOK-AUTH-LIFECYCLE-ENFORCEMENT] missing interaction lifecycle deny response fixture key in OpenAPI authz route';
}
if (!str_contains($openapi, '#/components/examples/ErrorInteractionLifecycleBlocked')) {
    $errors[] = '[HOOK-AUTH-LIFECYCLE-ENFORCEMENT] missing ErrorInteractionLifecycleBlocked deny fixture reference in OpenAPI authz route';
}
if (!str_contains($openapi, 'depthExceeded:')) {
    $errors[] = '[HOOK-AUTH-INHERITANCE-BOUNDARY] missing depthExceeded deny response fixture key in OpenAPI authz route';
}
if (!str_contains($openapi, '#/components/examples/ErrorAuthDepthExceeded')) {
    $errors[] = '[HOOK-AUTH-INHERITANCE-BOUNDARY] missing ErrorAuthDepthExceeded deny fixture reference in OpenAPI authz route';
}

if ($errors !== []) {
    foreach ($errors as $e) {
        fwrite(STDERR, $e . PHP_EOL);
    }
    exit(1);
}

echo 'test:contract:auth PASS (policy_steps=' . count($found) . ', inheritance_boundary=ok, lifecycle_enforcement=ok, openapi_authz_fixtures=validated, short_circuit=deterministic_first_fail)' . PHP_EOL;
