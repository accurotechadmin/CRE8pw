<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$routeInventoryPath = $repoRoot . '/docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md';
$errorCatalogPath = $repoRoot . '/docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md';

$routeInventory = file_get_contents($routeInventoryPath);
$errorCatalog = file_get_contents($errorCatalogPath);
if ($routeInventory === false || $errorCatalog === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-ERROR-DETERMINISM] unable to read route inventory or error catalog" . PHP_EOL);
    exit(1);
}

$catalogByCode = [];
foreach (explode("\n", $errorCatalog) as $line) {
    if (preg_match('/^\|\s*([A-Z0-9_]+)\s*\|\s*([A-Z_]+)\s*\|\s*([0-9]{3})\s*\|/', trim($line), $m) !== 1) {
        continue;
    }
    if ($m[1] === 'code') {
        continue;
    }
    $catalogByCode[$m[1]] = ['category' => $m[2], 'status' => (int) $m[3]];
}

if ($catalogByCode === []) {
    fwrite(STDERR, "[HOOK-CONTRACT-ERROR-DETERMINISM] error catalog baseline table not found" . PHP_EOL);
    exit(1);
}

$failures = [];
$routeRows = 0;
foreach (explode("\n", $routeInventory) as $line) {
    if (!preg_match('/^\|\s*(CRE8-ROUTE-[0-9]{4})\s*\|/i', trim($line), $m)) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 8) {
        $failures[] = "[HOOK-CONTRACT-ERROR-DETERMINISM] {$m[1]} malformed table row; expected >=8 columns";
        continue;
    }
    $routeRows++;
    $routeId = strtoupper($cols[0]);
    $codes = array_filter(array_map('trim', explode(',', $cols[7])));
    foreach ($codes as $code) {
        $code = strtoupper($code);
        if (!isset($catalogByCode[$code])) {
            $failures[] = "[HOOK-CONTRACT-ERROR-DETERMINISM] {$routeId} references unknown error code {$code}";
            continue;
        }
        $status = $catalogByCode[$code]['status'];
        if ($status < 400 || $status > 599) {
            $failures[] = "[HOOK-CONTRACT-ERROR-DETERMINISM] {$routeId} error code {$code} has non-error HTTP status {$status}";
        }
    }
}

if ($routeRows === 0) {
    $failures[] = '[HOOK-CONTRACT-ERROR-DETERMINISM] no route rows discovered in route inventory';
}

if ($failures !== []) {
    foreach ($failures as $failure) {
        fwrite(STDERR, $failure . PHP_EOL);
    }
    exit(1);
}

echo 'test:contract:error PASS (routes=' . $routeRows . ', catalog_codes=' . count($catalogByCode) . ')' . PHP_EOL;
