<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/Application/RuntimeTerms.php';
require dirname(__DIR__) . '/src/Policy/PolicyDecisionPointInterface.php';
require dirname(__DIR__) . '/src/Policy/PrincipalTaxonomy.php';
require dirname(__DIR__) . '/src/Policy/PermissionVocabulary.php';
require dirname(__DIR__) . '/src/Policy/InMemoryPolicyDecisionPoint.php';

use Cre8\Application\RuntimeTerms;
use Cre8\Policy\InMemoryPolicyDecisionPoint;

$pdp = new InMemoryPolicyDecisionPoint();
$base = [
    'principal_type' => 'IDENTITY_OPERATOR',
    'required_permission' => 'authz.decide',
    'lifecycle_state' => 'active',
    'credential_valid' => true,
    'explicit_deny' => false,
    'scope_match' => true,
    'permission_match' => true,
    'depth_ok' => true,
    'not_expired' => true,
];

$allow = $pdp->decide($base);
if (($allow['outcome'] ?? null) !== RuntimeTerms::allow()) {
    fwrite(STDERR, '[HOOK-CONTRACT-POLICY-ORDER] allow baseline failed' . PHP_EOL); exit(1);
}

$gateExpectations = [
    1 => ['lifecycle_state', 'suspended', 'AUTH_LIFECYCLE_BLOCKED'],
    2 => ['credential_valid', false, 'AUTH_CREDENTIAL_INVALID'],
    3 => ['explicit_deny', true, 'AUTH_EXPLICIT_DENY'],
    4 => ['scope_match', false, 'AUTH_SCOPE_DENIED'],
    5 => ['permission_match', false, 'AUTH_PERMISSION_DENIED'],
    6 => ['depth_ok', false, 'AUTH_DEPTH_EXCEEDED'],
    7 => ['not_expired', false, 'AUTH_GRANT_EXPIRED'],
];
foreach ($gateExpectations as $step => [$field, $value, $reason]) {
    $ctx = $base; $ctx[$field] = $value;
    $result = $pdp->decide($ctx);
    if (($result['reason_code'] ?? null) !== $reason || ($result['evaluated_gate'] ?? null) !== $step) {
        fwrite(STDERR, "[HOOK-CONTRACT-POLICY-ORDER] gate {$step} mismatch" . PHP_EOL); exit(1);
    }
}

echo "test:contract:auth-pdp PASS" . PHP_EOL;
