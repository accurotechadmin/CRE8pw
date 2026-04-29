<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$decisionTablesPath = $repoRoot . '/docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md';
$errorCatalogPath = $repoRoot . '/docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md';

$decisionTables = file_get_contents($decisionTablesPath);
$errorCatalog = file_get_contents($errorCatalogPath);
if ($decisionTables === false || $errorCatalog === false) {
    fwrite(STDERR, "[HOOK-AUTH-DECISION-REASON-MAPPING] unable to read decision tables or error catalog" . PHP_EOL);
    exit(1);
}

$decisionReasons = [];
foreach (explode("\n", $decisionTables) as $line) {
    if (preg_match('/^\|\s*[0-9]+\s*\|[^|]*\|[^|]*\|[^|]*\|\s*`([A-Z0-9_]+)`\s*\|/', trim($line), $m) === 1) {
        $decisionReasons[$m[1]] = true;
    }
}

$catalogCodes = [];
foreach (explode("\n", $errorCatalog) as $line) {
    if (preg_match('/^\|\s*([A-Z0-9_]+)\s*\|/', trim($line), $m) === 1 && $m[1] !== 'code') {
        $catalogCodes[$m[1]] = true;
    }
}

$missing = [];
foreach (array_keys($decisionReasons) as $reasonCode) {
    if (!isset($catalogCodes[$reasonCode])) {
        $missing[] = "[HOOK-AUTH-DECISION-REASON-MAPPING] decision reason {$reasonCode} is missing from ERROR_CODE_CATALOG.md";
    }
}

if ($decisionReasons === []) {
    $missing[] = '[HOOK-AUTH-DECISION-REASON-MAPPING] no decision reason rows discovered in authorization decision table';
}

if ($missing !== []) {
    foreach ($missing as $failure) {
        fwrite(STDERR, $failure . PHP_EOL);
    }
    exit(1);
}

echo 'test:contract:auth-reasons PASS (reasons=' . count($decisionReasons) . ')' . PHP_EOL;
