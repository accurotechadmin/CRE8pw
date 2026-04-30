<?php

declare(strict_types=1);

$specPath = dirname(__DIR__) . '/docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md';
$openapiPath = dirname(__DIR__) . '/docs/31_machine_contracts/openapi/cre8.v1.yaml';
$spec = file_get_contents($specPath);
$openapi = file_get_contents($openapiPath);
if ($spec === false || $openapi === false) {
    fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] unable to read identity model spec" . PHP_EOL);
    exit(1);
}

$requiredClause = 'Utility keypairs **MUST** be context-scoped and **MUST NOT** be reused across distinct trust contexts (`service`, `app`, `device`, `tenant`, or equivalent policy-defined boundary).';
if (!str_contains($spec, $requiredClause)) {
    fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] CRE8-ARCH-REQ-0002 canonical context-isolation clause drift detected" . PHP_EOL);
    exit(1);
}

if (!str_contains($spec, 'HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION')) {
    fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] verification hook declaration missing from identity model spec" . PHP_EOL);
    exit(1);
}

$allowedFixtures = [
    ['utility_key_id' => 'uk_srv_001', 'context' => 'service:gateway'],
    ['utility_key_id' => 'uk_app_001', 'context' => 'app:owner-console'],
];

$crossContextReuseFixture = [
    ['utility_key_id' => 'uk_shared_001', 'context' => 'service:gateway'],
    ['utility_key_id' => 'uk_shared_001', 'context' => 'tenant:t-02'],
];

$contextByKey = [];
foreach ($allowedFixtures as $row) {
    $contextByKey[$row['utility_key_id']] = $row['context'];
}

$reuseDetected = false;
$reuseKey = '';
foreach ($crossContextReuseFixture as $row) {
    if (isset($contextByKey[$row['utility_key_id']]) && $contextByKey[$row['utility_key_id']] !== $row['context']) {
        $reuseDetected = true;
        $reuseKey = $row['utility_key_id'];
        break;
    }
    $contextByKey[$row['utility_key_id']] = $row['context'];
}


$multiContextFixture = [
    ['utility_key_id' => 'uk_dev_001', 'context' => 'device:d-01', 'request_id' => 'req-ident-ctx-001', 'timestamp_utc' => '2026-04-30T00:05:00Z'],
    ['utility_key_id' => 'uk_tnt_001', 'context' => 'tenant:t-01', 'request_id' => 'req-ident-ctx-002', 'timestamp_utc' => '2026-04-30T00:05:01Z'],
    ['utility_key_id' => 'uk_srv_002', 'context' => 'service:worker', 'request_id' => 'req-ident-ctx-003', 'timestamp_utc' => '2026-04-30T00:05:02Z'],
];

foreach ($multiContextFixture as $row) {
    if (!str_starts_with($row['request_id'], 'req-ident-ctx-')) {
        fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] replay-safe request_id namespace drift in context fixture" . PHP_EOL);
        exit(1);
    }
    if (strtotime($row['timestamp_utc']) === false) {
        fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] timestamp_utc must be parseable ISO-8601 in context fixture" . PHP_EOL);
        exit(1);
    }
}

if (!$reuseDetected) {
    fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] expected cross-context key reuse deny-path fixture to be detected" . PHP_EOL);
    exit(1);
}


$runtimeIsolationFixture = [
    ['utility_key_id' => 'uk_rt_a_001', 'principal_id' => 'p-root-001', 'context' => 'tenant:t-a', 'actor_id' => 'issuer-tenant-a', 'request_id' => 'req-ident-ctx-rt-001', 'timestamp_utc' => '2026-04-30T00:11:00Z'],
    ['utility_key_id' => 'uk_rt_b_001', 'principal_id' => 'p-root-001', 'context' => 'tenant:t-b', 'actor_id' => 'issuer-tenant-b', 'request_id' => 'req-ident-ctx-rt-002', 'timestamp_utc' => '2026-04-30T00:11:01Z'],
];

$runtimeContextByPrincipal = [];
foreach ($runtimeIsolationFixture as $row) {
    if (!str_starts_with($row['request_id'], 'req-ident-ctx-rt-')) {
        fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] runtime context fixture request_id namespace drift detected" . PHP_EOL);
        exit(1);
    }
    if (strtotime($row['timestamp_utc']) === false) {
        fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] runtime context fixture timestamp_utc must be parseable ISO-8601" . PHP_EOL);
        exit(1);
    }

    $principal = $row['principal_id'];
    $context = $row['context'];
    if (!isset($runtimeContextByPrincipal[$principal])) {
        $runtimeContextByPrincipal[$principal] = [];
    }
    $runtimeContextByPrincipal[$principal][$context] = true;
}


$runtimeCrossPrincipalFixture = [
    ['utility_key_id' => 'uk_rt_a_002', 'principal_id' => 'p-root-001', 'context' => 'service:gateway', 'actor_id' => 'issuer-svc-a', 'request_id' => 'req-ident-ctx-rt-003', 'timestamp_utc' => '2026-04-30T00:11:02Z'],
    ['utility_key_id' => 'uk_rt_b_002', 'principal_id' => 'p-root-002', 'context' => 'service:gateway', 'actor_id' => 'issuer-svc-b', 'request_id' => 'req-ident-ctx-rt-004', 'timestamp_utc' => '2026-04-30T00:11:03Z'],
];

$seenRuntimeContextPrincipalPairs = [];
foreach ($runtimeCrossPrincipalFixture as $row) {
    if (!str_starts_with($row['request_id'], 'req-ident-ctx-rt-')) {
        fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] runtime cross-principal fixture request_id namespace drift detected" . PHP_EOL);
        exit(1);
    }
    if (strtotime($row['timestamp_utc']) === false) {
        fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] runtime cross-principal fixture timestamp_utc must be parseable ISO-8601" . PHP_EOL);
        exit(1);
    }

    $pair = $row['context'] . '|' . $row['principal_id'];
    $seenRuntimeContextPrincipalPairs[$pair] = true;
}

if (count($seenRuntimeContextPrincipalPairs) < 2) {
    fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] expected runtime cross-principal fixture to model same-context issuance for at least two principals" . PHP_EOL);
    exit(1);
}

foreach ($runtimeContextByPrincipal as $principal => $contexts) {
    if (count($contexts) < 2) {
        fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] expected runtime isolation fixture to model same-principal multi-context issuance for " . $principal . PHP_EOL);
        exit(1);
    }
}
if (!preg_match('/AuthDecisionRequestIdentityTransitionAllow:\n\s{6}value:\s\{[^\n]*utility_context_ref:\s"(req-ident-ctx-rt-[0-9]{3})"/m', $openapi, $allowContextRef)) {
    fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] missing replay-safe utility_context_ref in AuthDecisionRequestIdentityTransitionAllow fixture" . PHP_EOL);
    exit(1);
}
$runtimeContextRequestIds = [];
foreach (array_merge($runtimeIsolationFixture, $runtimeCrossPrincipalFixture) as $row) {
    $runtimeContextRequestIds[$row['request_id']] = true;
}
if (!isset($runtimeContextRequestIds[$allowContextRef[1]])) {
    fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] OpenAPI identity transition allow fixture must reference runtime context request_id fixture" . PHP_EOL);
    exit(1);
}
echo 'test:contract:identity-context PASS (hook=HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION, clauses=1, allowed_fixtures=' . count($allowedFixtures) . ', extra_context_fixtures=' . count($multiContextFixture) . ', runtime_isolation_fixtures=' . count($runtimeIsolationFixture) . ', runtime_cross_principal_fixtures=' . count($runtimeCrossPrincipalFixture) . ', deny_reuse_key=' . $reuseKey . ', replay_safe_namespace=req-ident-ctx-*|req-ident-ctx-rt-*)' . PHP_EOL;
