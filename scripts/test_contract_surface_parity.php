<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$uiContractPath = $root . '/docs/30_contracts_and_interfaces/UI_RUNTIME_CONTRACT.md';
$routeInventoryPath = $root . '/docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md';

$ui = file_get_contents($uiContractPath);
$inventory = file_get_contents($routeInventoryPath);
if ($ui === false || $inventory === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] unable to read required docs\n");
    exit(1);
}

$routeById = [];
foreach (explode("\n", $inventory) as $line) {
    if (!preg_match('/^\|\s*(CRE8-ROUTE-\d{4})\s*\|\s*([A-Z]+)\s*\|\s*([^|]+)\|/', trim($line), $m)) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 11) {
        continue;
    }
    $routeById[$m[1]] = [
        'method' => trim($m[2]),
        'path' => trim($m[3]),
        'auth_model' => $cols[3],
        'required_permission' => $cols[4],
        'scope_type' => $cols[5],
    ];
}

$rows = [];
foreach (explode("\n", $ui) as $line) {
    if (!preg_match('/^\|\s*(CAP-[^|]+)\|/', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) !== 13) {
        fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] malformed parity row for capability: {$cols[0]}\n");
        exit(1);
    }
    $rows[] = $cols;
}

if ($rows === []) {
    fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] parity matrix rows not found\n");
    exit(1);
}

foreach ($rows as $row) {
    [$cap, $status, $routeId, $method, $path, $expectedAuthModel, $expectedRequiredPermission, $expectedScopeType, $parityStatus, $exceptionClass, $justification, $owner, $reviewDue] = $row;
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $reviewDue)) {
        fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] invalid review_due_utc for {$cap}: {$reviewDue}\n");
        exit(1);
    }
    if ($status === 'supported') {
        if ($parityStatus !== 'parity_mapped' || !isset($routeById[$routeId])) {
            fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] supported capability missing valid mapped route: {$cap}\n");
            exit(1);
        }
        if ($routeById[$routeId]['method'] !== $method || $routeById[$routeId]['path'] !== $path) {
            fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] route mismatch for {$cap} against {$routeId}\n");
            exit(1);
        }
        if ($routeById[$routeId]['auth_model'] !== $expectedAuthModel || $routeById[$routeId]['required_permission'] !== $expectedRequiredPermission || $routeById[$routeId]['scope_type'] !== $expectedScopeType) {
            fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] auth prerequisite mismatch for {$cap} against {$routeId}\n");
            exit(1);
        }
    }
    if ($status === 'ui_only') {
        if ($parityStatus !== 'exception_documented' || $exceptionClass === 'n/a' || $justification === 'n/a') {
            fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] ui_only capability missing exception metadata: {$cap}\n");
            exit(1);
        }
    }
    if ($owner === '' || $owner === 'n/a') {
        fwrite(STDERR, "[HOOK-CONTRACT-SURFACE-PARITY] owner missing for {$cap}\n");
        exit(1);
    }
}

echo 'test:contract:surface-parity PASS (capabilities=' . count($rows) . ',mapped=' . count(array_filter($rows, fn($r) => $r[1] === 'supported')) . ',exceptions=' . count(array_filter($rows, fn($r) => $r[1] === 'ui_only')) . ')' . PHP_EOL;
