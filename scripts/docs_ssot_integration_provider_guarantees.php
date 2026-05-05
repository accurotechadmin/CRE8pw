<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$manifestPath = $root . '/tests/contract/fixtures/extensions/integration_provider_manifest.json';
$manifest = json_decode((string) file_get_contents($manifestPath), true);
if (!is_array($manifest)) {
    fwrite(STDERR, "[HOOK-EXT-INTEGRATION-PROVIDER-GUARANTEES] FAIL invalid/missing provider manifest fixture\n");
    exit(1);
}

$required = ['provider_id','transport_protocol','signature_profile','retry_class','dead_letter_destination','contract_version','seam_tests'];
$errors = [];
foreach ($required as $field) {
    if (!array_key_exists($field, $manifest) || $manifest[$field] === '' || $manifest[$field] === []) {
        $errors[] = "missing {$field}";
    }
}
foreach (['successful_delivery','retryable_failure','non_retryable_failure','replay_rejection','signature_key_rotation'] as $testCase) {
    if (!in_array($testCase, $manifest['seam_tests'] ?? [], true)) {
        $errors[] = "missing seam test {$testCase}";
    }
}
if (($manifest['signature_required_for_authenticated_routes'] ?? false) !== true) {
    $errors[] = 'signature_required_for_authenticated_routes must be true';
}
if ($errors) {
    foreach ($errors as $e) fwrite(STDERR, "[HOOK-EXT-INTEGRATION-PROVIDER-GUARANTEES] FAIL {$e}\n");
    exit(1);
}

echo "[HOOK-EXT-INTEGRATION-PROVIDER-GUARANTEES] PASS\n";
