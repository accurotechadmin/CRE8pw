<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$routeInventoryPath = $repoRoot . '/docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md';
$routeInventory = file_get_contents($routeInventoryPath);
if ($routeInventory === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-DEPRECATION-SCHEMA] unable to read route inventory" . PHP_EOL);
    exit(1);
}

$errors = [];
$routeRows = 0;
$deprecatedRows = 0;

foreach (explode("\n", $routeInventory) as $line) {
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }

    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 11) {
        $errors[] = '[HOOK-CONTRACT-DEPRECATION-SCHEMA] malformed route row (expected 11 columns): ' . trim($line);
        continue;
    }

    $routeRows++;
    $routeId = strtoupper($cols[0]);
    $lifecycle = strtolower($cols[8]);
    $sunsetUtc = $cols[9];
    $replacementRouteId = strtoupper($cols[10]);

    if (in_array($lifecycle, ['deprecated', 'sunset'], true)) {
        $deprecatedRows++;

        if ($sunsetUtc === '' || $sunsetUtc === 'TBD') {
            $errors[] = "[HOOK-CONTRACT-DEPRECATION-SCHEMA] {$routeId} missing required sunset_utc for lifecycle={$lifecycle}";
        }

        if ($replacementRouteId === '' || $replacementRouteId === 'TBD') {
            $errors[] = "[HOOK-CONTRACT-DEPRECATION-SCHEMA] {$routeId} missing required replacement_route_id for lifecycle={$lifecycle}";
        }

        if ($replacementRouteId !== '' && $replacementRouteId !== 'TBD' && preg_match('/^CRE8-ROUTE-[0-9]{4}$/', $replacementRouteId) !== 1) {
            $errors[] = "[HOOK-CONTRACT-DEPRECATION-SCHEMA] {$routeId} replacement_route_id must match CRE8-ROUTE-####, got {$replacementRouteId}";
        }
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'docs:ssot:deprecation-schema PASS (routes=' . $routeRows . ', deprecated_or_sunset_routes=' . $deprecatedRows . ')' . PHP_EOL;
