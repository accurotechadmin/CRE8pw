<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$routeInventoryPath = $repoRoot . '/docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md';
$openApiPath = $repoRoot . '/docs/31_machine_contracts/openapi/cre8.v1.yaml';

$routeInventory = file_get_contents($routeInventoryPath);
$openApi = file_get_contents($openApiPath);
if ($routeInventory === false || $openApi === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] unable to read route inventory or OpenAPI file" . PHP_EOL);
    exit(1);
}

$inventoryPairs = [];
foreach (explode("\n", $routeInventory) as $line) {
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 3) {
        continue;
    }
    $method = strtoupper($cols[1]);
    $path = $cols[2];
    $inventoryPairs[$method . ' ' . $path] = true;
}

$openApiPairs = [];
$lines = explode("\n", $openApi);
$currentPath = null;
foreach ($lines as $line) {
    if (preg_match('/^\s{2}(\/[^:]+):\s*$/', $line, $m) === 1) {
        $currentPath = trim($m[1]);
        continue;
    }
    if ($currentPath !== null && preg_match('/^\s{4}(get|post|put|patch|delete|options|head):\s*$/i', $line, $m) === 1) {
        $method = strtoupper($m[1]);
        $openApiPairs[$method . ' ' . $currentPath] = true;
    }
}

$errors = [];
foreach (array_keys($inventoryPairs) as $pair) {
    if (!isset($openApiPairs[$pair])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing in OpenAPI: {$pair}";
    }
}
foreach (array_keys($openApiPairs) as $pair) {
    if (!isset($inventoryPairs[$pair])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing in route inventory: {$pair}";
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'docs:ssot:route-parity PASS (pairs=' . count($inventoryPairs) . ')' . PHP_EOL;
