<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$routeInventoryPath = $repoRoot . '/docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md';
$routeInventory = file_get_contents($routeInventoryPath);
if ($routeInventory === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-ROUTE-UNIQUENESS] unable to read route inventory" . PHP_EOL);
    exit(1);
}

$routeIdSeen = [];
$methodPathSeen = [];
$errors = [];
$rowCount = 0;

foreach (explode("\n", $routeInventory) as $line) {
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 3) {
        continue;
    }

    $rowCount++;
    $routeId = strtoupper($cols[0]);
    $method = strtoupper($cols[1]);
    $path = $cols[2];
    $pair = $method . ' ' . $path;

    if (isset($routeIdSeen[$routeId])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-UNIQUENESS] duplicate route_id: {$routeId}";
    }
    $routeIdSeen[$routeId] = true;

    if (isset($methodPathSeen[$pair])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-UNIQUENESS] duplicate method/path: {$pair}";
    }
    $methodPathSeen[$pair] = true;
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'docs:ssot:route-uniqueness PASS (routes=' . $rowCount . ')' . PHP_EOL;
