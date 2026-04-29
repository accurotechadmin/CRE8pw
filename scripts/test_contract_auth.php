<?php

declare(strict_types=1);

$path = dirname(__DIR__) . '/docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md';
$content = file_get_contents($path);
if ($content === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-POLICY-ORDER] unable to read authorization decision table" . PHP_EOL);
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
foreach (explode("\n", $content) as $line) {
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

if ($errors !== []) {
    foreach ($errors as $e) fwrite(STDERR, $e . PHP_EOL);
    exit(1);
}

echo 'test:contract:auth PASS (steps=' . count($found) . ', short_circuit=deterministic_first_fail)' . PHP_EOL;
