<?php
declare(strict_types=1);

$root = dirname(__DIR__);
$openapiPath = $root . '/docs/31_machine_contracts/openapi/cre8.v1.yaml';
$schemaPath = $root . '/docs/31_machine_contracts/schemas/feed-items-response.schema.json';

if (!is_file($openapiPath) || !is_file($schemaPath)) {
    fwrite(STDERR, "Required contract artifacts missing.\n");
    exit(1);
}

$openapi = file_get_contents($openapiPath);
$schema = json_decode((string) file_get_contents($schemaPath), true);
if ($openapi === false || !is_array($schema)) {
    fwrite(STDERR, "Failed to load contract artifacts.\n");
    exit(1);
}

$requiredSnippets = [
    'action: "comment.create"' => 'interaction allow fixture request',
    'AUTH_PERMISSION_DENIED' => 'permission deny mapping',
    'AUTH_SCOPE_DENIED' => 'scope deny mapping',
    'AUTH_DEPTH_EXCEEDED' => 'depth deny mapping',
    'AUTH_GRANT_EXPIRED' => 'grant-expired deny mapping',
    'AUTH_LIFECYCLE_BLOCKED' => 'lifecycle-blocked deny mapping',
];

foreach ($requiredSnippets as $snippet => $label) {
    if (strpos($openapi, $snippet) === false) {
        fwrite(STDERR, "Missing {$label} snippet in OpenAPI feed/authz fixtures: {$snippet}\n");
        exit(1);
    }
}

$itemProps = $schema['properties']['data']['items']['properties'] ?? null;
if (!is_array($itemProps)) {
    fwrite(STDERR, "Feed schema item properties missing.\n");
    exit(1);
}

$requiredItemFields = ['item_id', 'rank', 'visibility_scope', 'published_utc'];
foreach ($requiredItemFields as $field) {
    if (!array_key_exists($field, $itemProps)) {
        fwrite(STDERR, "Missing required feed item field in schema: {$field}\n");
        exit(1);
    }
}

$expectedOptionalStabilityFields = ['audience_labels', 'moderation_state'];
foreach ($expectedOptionalStabilityFields as $field) {
    if (!array_key_exists($field, $itemProps)) {
        fwrite(STDERR, "Missing feed metadata stability field in schema: {$field}\n");
        exit(1);
    }
}

echo 'test:contract:feed PASS (allow_fixture=comment.create, deny_mappings=5, metadata_fields=2)' . PHP_EOL;
