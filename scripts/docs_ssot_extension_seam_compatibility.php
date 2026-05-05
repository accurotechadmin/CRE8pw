<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$fixturePath = $repoRoot . '/tests/contract/fixtures/extensions/extension_seam_manifest.json';
$manifest = json_decode((string) file_get_contents($fixturePath), true);
if (!is_array($manifest)) {
    fwrite(STDERR, "[HOOK-EXT-SEAM-COMPATIBILITY] FAIL: invalid or missing manifest fixture\n");
    exit(1);
}

$required = [
    'compatibility_posture',
    'pdp_chain_preserved',
    'envelope_compatibility',
    'lifecycle_impact',
    'provenance_impact',
    'di_registration',
    'route_binding',
    'middleware_order',
    'core_controls_preserved',
];

$errors = [];
foreach ($required as $field) {
    if (!array_key_exists($field, $manifest)) {
        $errors[] = "missing field: {$field}";
    }
}

if (!in_array(($manifest['compatibility_posture'] ?? ''), ['compatible', 'additive', 'breaking'], true)) {
    $errors[] = 'compatibility_posture must be one of compatible/additive/breaking';
}
if (($manifest['pdp_chain_preserved'] ?? false) !== true) {
    $errors[] = 'pdp_chain_preserved must be true';
}
if (($manifest['core_controls_preserved'] ?? false) !== true) {
    $errors[] = 'core_controls_preserved must be true';
}
if (($manifest['middleware_order'] ?? '') !== 'canonical') {
    $errors[] = 'middleware_order must be canonical';
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, "[HOOK-EXT-SEAM-COMPATIBILITY] FAIL: {$error}\n");
    }
    exit(1);
}

echo '[HOOK-EXT-SEAM-COMPATIBILITY] PASS: extension seam manifest invariants satisfied.' . PHP_EOL;
