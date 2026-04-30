<?php

declare(strict_types=1);

$specPath = dirname(__DIR__) . '/docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md';
$spec = file_get_contents($specPath);
if ($spec === false) {
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

echo 'test:contract:identity-context PASS (hook=HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION, clauses=1, allowed_fixtures=' . count($allowedFixtures) . ', extra_context_fixtures=' . count($multiContextFixture) . ', deny_reuse_key=' . $reuseKey . ', replay_safe_namespace=req-ident-ctx-*)' . PHP_EOL;
