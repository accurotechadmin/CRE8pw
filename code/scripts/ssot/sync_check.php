<?php

declare(strict_types=1);

require_once __DIR__ . '/Support/ssot_lib.php';

$repoRoot = ssot_repo_root();
$inventoryFile = $repoRoot . '/docs/SSOT/Route_Inventory_Reference.md';
$openApiFile = $repoRoot . '/docs/SSOT/openapi/cre8.v1.yaml';

$inventoryRoutes = ssot_parse_route_inventory($inventoryFile);
$openapiRoutes = ssot_parse_openapi_paths($openApiFile);
$routeDiff = ssot_diff_routes($inventoryRoutes, $openapiRoutes);

$missingInOpenApi = $routeDiff['missing_in_openapi'];
$missingInInventory = $routeDiff['missing_in_inventory'];
$totalIssueCount = count($missingInOpenApi) + count($missingInInventory);

$payload = [
    'check' => 'sync-check',
    'generated_at_utc' => gmdate(DATE_ATOM),
    'inventory_file' => $inventoryFile,
    'openapi_file' => $openApiFile,
    'counts' => [
        'inventory_routes' => count($inventoryRoutes),
        'openapi_routes' => count($openapiRoutes),
        'missing_in_openapi' => count($missingInOpenApi),
        'missing_in_inventory' => count($missingInInventory),
    ],
    'missing_in_openapi' => $missingInOpenApi,
    'missing_in_inventory' => $missingInInventory,
    'passed' => $totalIssueCount === 0,
];

ssot_write_json_report('sync_check.json', $payload);

fwrite(STDOUT, "[ssot-sync] Route inventory: {$inventoryFile}\n");
fwrite(STDOUT, "[ssot-sync] OpenAPI: {$openApiFile}\n");
fwrite(STDOUT, '[ssot-sync] Inventory routes: ' . count($inventoryRoutes) . "\n");
fwrite(STDOUT, '[ssot-sync] OpenAPI routes: ' . count($openapiRoutes) . "\n");
fwrite(STDOUT, '[ssot-sync] Missing in OpenAPI: ' . count($missingInOpenApi) . "\n");
fwrite(STDOUT, '[ssot-sync] Missing in inventory: ' . count($missingInInventory) . "\n");
fwrite(STDOUT, "[ssot-sync] JSON report: code/build/ssot/sync_check.json\n");

if ($totalIssueCount > 0) {
    fwrite(STDOUT, "[ssot-sync] FAIL: Route inventory/OpenAPI drift detected.\n");
    exit(1);
}

fwrite(STDOUT, "[ssot-sync] PASS\n");
exit(0);
