<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$fixturePath = $root . '/tests/contract/fixtures/extensions/inbound_webhook_cases.json';
$cases = json_decode((string) file_get_contents($fixturePath), true);
if (!is_array($cases) || !isset($cases['cases']) || !is_array($cases['cases'])) {
    fwrite(STDERR, "test:contract:webhook-inbound FAIL invalid fixture\n");
    exit(1);
}

$requiredOutcomes = [
    'valid_signed_payload' => 'allow',
    'invalid_signature' => 'deny_signature',
    'replay_nonce' => 'deny_replay',
    'duplicate_idempotency_key' => 'deny_idempotency',
    'schema_invalid_payload' => 'deny_schema',
];

foreach ($requiredOutcomes as $name => $outcome) {
    $found = false;
    foreach ($cases['cases'] as $case) {
        if (($case['name'] ?? '') === $name) {
            $found = true;
            if (($case['expected'] ?? '') !== $outcome) {
                fwrite(STDERR, "test:contract:webhook-inbound FAIL {$name} expected {$outcome}\n");
                exit(1);
            }
        }
    }
    if (!$found) {
        fwrite(STDERR, "test:contract:webhook-inbound FAIL missing {$name}\n");
        exit(1);
    }
}

echo "test:contract:webhook-inbound PASS\n";
