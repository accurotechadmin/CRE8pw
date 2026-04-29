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

$orderingSnippets = [
    'item_id: "itm_001", rank: 1, visibility_scope: "group:g-123", published_utc: "2026-04-29T05:59:00Z"' => 'first feed item ordering fixture',
    'item_id: "itm_002", rank: 2, visibility_scope: "group:g-123", published_utc: "2026-04-29T05:54:00Z"' => 'second feed item ordering fixture',
    'item_id: "itm_003", rank: 3, visibility_scope: "group:g-123", published_utc: "2026-04-29T05:54:00Z"' => 'tie-case feed item ordering fixture',
    'next_cursor: "pub:2026-04-29T05:54:00Z|itm_003"' => 'cursor fixture aligned to last returned item',
    'cursor_basis: "published_utc_desc__item_id_asc"' => 'cursor basis fixture',
];

foreach ($orderingSnippets as $snippet => $label) {
    if (strpos($openapi, $snippet) === false) {
        fwrite(STDERR, "Missing {$label} snippet in OpenAPI feed fixtures: {$snippet}\n");
        exit(1);
    }
}


$apiGuidePath = $root . '/docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md';
$errorCatalogPath = $root . '/docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md';
$apiGuide = is_file($apiGuidePath) ? file_get_contents($apiGuidePath) : false;
$errorCatalog = is_file($errorCatalogPath) ? file_get_contents($errorCatalogPath) : false;

if (!is_string($apiGuide) || strpos($apiGuide, 'CRE8-CONTRACT-REQ-0051') === false || strpos($apiGuide, 'feed_metadata_schema_version') === false || strpos($apiGuide, 'compatibility classification') === false) {
    fwrite(STDERR, "Missing feed metadata compatibility requirement in API contract guide (CRE8-CONTRACT-REQ-0051).\n");
    exit(1);
}

if (!is_string($errorCatalog)) {
    fwrite(STDERR, "Failed to load ERROR_CODE_CATALOG.md for feed deny mapping validation.\n");
    exit(1);
}

$feedDenyCodes = ['AUTH_PERMISSION_DENIED','AUTH_SCOPE_DENIED','AUTH_DEPTH_EXCEEDED','AUTH_GRANT_EXPIRED'];
foreach ($feedDenyCodes as $code) {
    if (strpos($errorCatalog, $code) === false) {
        fwrite(STDERR, "Feed deny code not found in canonical error catalog: {$code}\n");
        exit(1);
    }
}

echo 'test:contract:feed PASS (allow_fixture=comment.create, deny_mappings=5, metadata_fields=2, ordering_cursor=tiecase-validated, deny_catalog=validated)' . PHP_EOL;
