<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$files = [
    $root . '/tests/contract/fixtures/extensions/post_type_extension_manifest.json',
    $root . '/tests/contract/fixtures/extensions/principal_type_extension_manifest.json',
];

foreach ($files as $file) {
    $json = json_decode((string) file_get_contents($file), true);
    if (!is_array($json)) {
        fwrite(STDERR, "test:contract:extensions FAIL invalid json: {$file}\n");
        exit(1);
    }
}

$post = json_decode((string) file_get_contents($files[0]), true);
foreach (['post_type','validator_coverage','rollback_plan','policy_bindings'] as $field) {
    if (!array_key_exists($field, $post)) {
        fwrite(STDERR, "test:contract:extensions FAIL post manifest missing {$field}\n");
        exit(1);
    }
}
if (!isset($post['validator_coverage']['payload_schema'], $post['validator_coverage']['lifecycle_transition_guards'], $post['validator_coverage']['audience_eligibility'], $post['validator_coverage']['policy_token_resolution'])) {
    fwrite(STDERR, "test:contract:extensions FAIL post validator coverage incomplete\n");
    exit(1);
}

$principal = json_decode((string) file_get_contents($files[1]), true);
foreach (['principal_type','permission_tokens','capability_matrix_deltas','delegation_transitions','authz_fixtures','validator_coverage'] as $field) {
    if (!array_key_exists($field, $principal)) {
        fwrite(STDERR, "test:contract:extensions FAIL principal manifest missing {$field}\n");
        exit(1);
    }
}

echo "test:contract:extensions PASS\n";
