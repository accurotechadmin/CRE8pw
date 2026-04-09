<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$openapiPath = $root . '/from_scratch/ssot_canon/openapi/cre8.v1.yaml';
$routeInventoryPath = $root . '/from_scratch/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md';

$openapi = (string) file_get_contents($openapiPath);
$inventory = (string) file_get_contents($routeInventoryPath);

$openapiPairs = [];
$currentRoute = null;

foreach (preg_split('/\R/', $openapi) as $line) {
    if (preg_match('/^  (\/[^:]*):\s*$/', $line, $m) === 1) {
        $currentRoute = $m[1];
        continue;
    }

    if ($currentRoute !== null && preg_match('/^    (get|post|patch|delete|put):\s*$/', $line, $m) === 1) {
        $openapiPairs[] = strtoupper($m[1]) . ' ' . $currentRoute;
    }
}

$inventoryPairs = [];
foreach (preg_split('/\R/', $inventory) as $line) {
    if (!str_starts_with($line, '| `/')) {
        continue;
    }

    $cells = array_map('trim', explode('|', trim($line, '|')));
    if (count($cells) < 2) {
        continue;
    }

    $route = trim($cells[0], '`');
    $methodCell = strtoupper(trim($cells[1]));
    $methods = explode('/', $methodCell);

    foreach ($methods as $method) {
        $method = trim($method);
        if ($method === '') {
            continue;
        }

        $inventoryPairs[] = $method . ' ' . $route;
    }
}

$openapiSet = array_values(array_unique($openapiPairs));
$inventorySet = array_values(array_unique($inventoryPairs));
sort($openapiSet);
sort($inventorySet);

$missingInOpenapi = array_values(array_diff($inventorySet, $openapiSet));
$missingInInventory = array_values(array_diff($openapiSet, $inventorySet));

if ($missingInOpenapi !== [] || $missingInInventory !== []) {
    fwrite(STDERR, "docs_ssot_sync_check_failed\n");
    fwrite(STDERR, json_encode([
        'missing_in_openapi' => $missingInOpenapi,
        'missing_in_inventory' => $missingInInventory,
    ], JSON_PRETTY_PRINT) . "\n");
    exit(1);
}

echo "docs_ssot_sync_check_ok\n";
