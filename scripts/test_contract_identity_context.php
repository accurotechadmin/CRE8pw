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

if (!$reuseDetected) {
    fwrite(STDERR, "[HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION] expected cross-context key reuse deny-path fixture to be detected" . PHP_EOL);
    exit(1);
}

echo 'test:contract:identity-context PASS (hook=HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION, clauses=1, allowed_fixtures=' . count($allowedFixtures) . ', deny_reuse_key=' . $reuseKey . ')' . PHP_EOL;
