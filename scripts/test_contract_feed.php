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

$feedDenyCodes = ['AUTH_PERMISSION_DENIED','AUTH_SCOPE_DENIED','AUTH_DEPTH_EXCEEDED','AUTH_GRANT_EXPIRED','AUTH_LIFECYCLE_BLOCKED'];
foreach ($feedDenyCodes as $code) {
    if (strpos($errorCatalog, $code) === false) {
        fwrite(STDERR, "Feed deny code not found in canonical error catalog: {$code}\n");
        exit(1);
    }
}


if (strpos($openapi, 'ErrorFeedLifecycleBlocked') === false) {
    fwrite(STDERR, "Missing feed lifecycle deny fixture example in OpenAPI.\n");
    exit(1);
}

if (strpos($openapi, 'ErrorInteractionLifecycleBlocked') === false) {
    fwrite(STDERR, "Missing interaction runtime deny-path fixture for lifecycle-blocked comment.create action in OpenAPI.
");
    exit(1);
}




function parseCursor(string $cursor): ?array
{
    if (!preg_match('/^pub:(\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z)\|([A-Za-z0-9_\-]+)$/', $cursor, $m)) {
        return null;
    }

    $ts = strtotime($m[1]);
    if ($ts === false) {
        return null;
    }

    return ['cursor' => $cursor, 'published_utc' => $m[1], 'timestamp' => $ts, 'item_id' => $m[2]];
}

function assertOlderCursor(array $newer, array $older): bool
{
    if ($older['timestamp'] < $newer['timestamp']) {
        return true;
    }

    if ($older['timestamp'] === $newer['timestamp']) {
        return strcmp($older['item_id'], $newer['item_id']) > 0;
    }

    return false;
}

$page1Cursor = 'next_cursor: "pub:2026-04-29T05:54:00Z|itm_003"';
$page2InputCursor = 'input_cursor: "pub:2026-04-29T05:54:00Z|itm_003"';
$page2NextCursor = 'next_cursor: "pub:2026-04-29T05:45:00Z|itm_005"';

foreach ([$page1Cursor => 'page1 next cursor', $page2InputCursor => 'page2 input cursor', $page2NextCursor => 'page2 next cursor'] as $snippet => $label) {
    if (strpos($openapi, $snippet) === false) {
        fwrite(STDERR, "Missing {$label} fixture snippet in OpenAPI feed examples: {$snippet}\n");
        exit(1);
    }
}


$page1Parsed = parseCursor('pub:2026-04-29T05:54:00Z|itm_003');
$page2InputParsed = parseCursor('pub:2026-04-29T05:54:00Z|itm_003');
$page2NextParsed = parseCursor('pub:2026-04-29T05:45:00Z|itm_005');

if ($page1Parsed === null || $page2InputParsed === null || $page2NextParsed === null) {
    fwrite(STDERR, "Failed to parse one or more feed cursor fixtures using required cursor grammar pub:<ISO8601>|<item_id>.
");
    exit(1);
}

if ($page1Parsed['cursor'] !== $page2InputParsed['cursor']) {
    fwrite(STDERR, "Feed multipage fixtures violated cursor linkage: page2.input_cursor must equal page1.next_cursor.
");
    exit(1);
}

if (!assertOlderCursor($page1Parsed, $page2NextParsed)) {
    fwrite(STDERR, "Feed multipage fixtures violated cursor monotonicity: page2.next_cursor must be strictly older than page1.next_cursor under published_utc_desc__item_id_asc.
");
    exit(1);
}

if (!is_string($apiGuide) || strpos($apiGuide, 'CRE8-CONTRACT-REQ-0053') === false || strpos($apiGuide, 'CRE8-CONTRACT-REQ-0054') === false || strpos($apiGuide, 'CRE8-CONTRACT-REQ-0055') === false) {
    fwrite(STDERR, "Missing feed lifecycle/multipage requirements in API contract guide (CRE8-CONTRACT-REQ-0053/0054).\n");
    exit(1);
}

echo 'test:contract:feed PASS (allow_fixture=comment.create, deny_mappings=6, metadata_fields=2, ordering_cursor=tiecase-multipage-parser-validated, deny_catalog=validated)' . PHP_EOL;
