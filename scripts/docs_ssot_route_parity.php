<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$routeInventoryPath = $repoRoot . '/docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md';
$openApiPath = $repoRoot . '/docs/31_machine_contracts/openapi/cre8.v1.yaml';
$proseParityPath = $repoRoot . '/docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md';

$routeInventory = file_get_contents($routeInventoryPath);
$openApi = file_get_contents($openApiPath);
$proseParity = file_get_contents($proseParityPath);
if ($routeInventory === false || $openApi === false || $proseParity === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] unable to read route inventory, OpenAPI, or prose parity file" . PHP_EOL);
    exit(1);
}

$inventoryPairs = [];
$inventoryRouteIds = [];
foreach (explode("\n", $routeInventory) as $line) {
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 3) {
        continue;
    }
    $routeId = strtoupper($cols[0]);
    $method = strtoupper($cols[1]);
    $path = $cols[2];
    $inventoryPairs[$method . ' ' . $path] = true;
    $inventoryRouteIds[$routeId] = $method . ' ' . $path;
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

// Validate prose parity table rows remain synchronized and contain Phase 2 depth metadata.
$proseRows = [];
foreach (explode("\n", $proseParity) as $line) {
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 13) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] malformed prose parity row: {$line}";
        continue;
    }

    [$routeId, $inventoryMethod, $inventoryPath, $openApiMethod, $openApiPath, $parityStatus, $routeFamily, $depthPriority, $requirementId, $hookId, $depthStatus, $successSchemaRef, $errorSchemaRef] = $cols;
    $routeId = strtoupper($routeId);
    $pair = strtoupper($inventoryMethod) . ' ' . $inventoryPath;
    $openApiPair = strtoupper($openApiMethod) . ' ' . $openApiPath;
    $proseRows[$routeId] = true;

    if (!isset($inventoryRouteIds[$routeId])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] prose parity route_id not found in inventory: {$routeId}";
    } elseif ($inventoryRouteIds[$routeId] !== $pair) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] prose inventory tuple mismatch for {$routeId}";
    }
    if (!isset($openApiPairs[$openApiPair])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] prose OpenAPI tuple missing for {$routeId}: {$openApiPair}";
    }
    if ($parityStatus !== 'in_sync') {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] parity_status must be in_sync for {$routeId}";
    }
    if (!preg_match('/^CRE8-[A-Z]+-REQ-[0-9]{4}$/', $requirementId)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid primary_requirement_id for {$routeId}: {$requirementId}";
    }
    if (!preg_match('/^HOOK-[A-Z0-9-]+$/', $hookId)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid primary_hook_id for {$routeId}: {$hookId}";
    }
    if ($routeFamily === '' || $depthPriority === '' || $depthStatus === '') {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing Phase 2 depth metadata for {$routeId}";
    }

    if (!preg_match('/^#\/components\/schemas\/[A-Za-z0-9._-]+$/', $successSchemaRef)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid success_schema_ref for {$routeId}: {$successSchemaRef}";
    } elseif (strpos($openApi, $successSchemaRef) === false) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] success_schema_ref not found in OpenAPI for {$routeId}: {$successSchemaRef}";
    }
    if (!preg_match('/^#\/components\/schemas\/[A-Za-z0-9._-]+$/', $errorSchemaRef)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid error_schema_ref for {$routeId}: {$errorSchemaRef}";
    } elseif (strpos($openApi, $errorSchemaRef) === false) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] error_schema_ref not found in OpenAPI for {$routeId}: {$errorSchemaRef}";
    }
}

foreach (array_keys($inventoryRouteIds) as $routeId) {
    if (!isset($proseRows[$routeId])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing route in prose parity table: {$routeId}";
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'docs:ssot:route-parity PASS (pairs=' . count($inventoryPairs) . ', prose_rows=' . count($proseRows) . ')' . PHP_EOL;
