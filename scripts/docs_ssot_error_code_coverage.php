<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$routeInventoryPath = $repoRoot . '/docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md';
$errorCatalogPath = $repoRoot . '/docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md';

$routeInventory = file_get_contents($routeInventoryPath);
$errorCatalog = file_get_contents($errorCatalogPath);
if ($routeInventory === false || $errorCatalog === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-ERROR-CODE-COVERAGE] unable to read route inventory or error catalog" . PHP_EOL);
    exit(1);
}

$catalogCodes = [];
foreach (explode("\n", $errorCatalog) as $line) {
    if (preg_match('/^\|\s*([A-Z0-9_]+)\s*\|/', trim($line), $m) !== 1) {
        continue;
    }
    if ($m[1] === 'code') {
        continue;
    }
    $catalogCodes[$m[1]] = true;
}

if ($catalogCodes === []) {
    fwrite(STDERR, "[HOOK-CONTRACT-ERROR-CODE-COVERAGE] no catalog codes discovered; expected baseline code table in ERROR_CODE_CATALOG.md" . PHP_EOL);
    exit(1);
}

$declaredCodes = [];
$missing = [];
$routeRows = 0;

foreach (explode("\n", $routeInventory) as $line) {
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 8) {
        continue;
    }

    $routeRows++;
    $routeId = strtoupper($cols[0]);
    $errorSet = $cols[7];
    $codes = array_filter(array_map('trim', explode(',', $errorSet)), static fn (string $code): bool => $code !== '');

    foreach ($codes as $code) {
        $normalized = strtoupper($code);
        $declaredCodes[$normalized] = true;
        if (!isset($catalogCodes[$normalized])) {
            $missing[] = "[HOOK-CONTRACT-ERROR-CODE-COVERAGE] {$routeId} references undocumented error code: {$normalized}";
        }
    }
}

if ($missing !== []) {
    foreach ($missing as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'docs:ssot:error-code-coverage PASS (routes=' . $routeRows . ', declared_codes=' . count($declaredCodes) . ', catalog_codes=' . count($catalogCodes) . ')' . PHP_EOL;
