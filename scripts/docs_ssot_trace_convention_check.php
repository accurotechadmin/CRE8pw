<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$matrixPath = $repoRoot . '/docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md';
$lines = @file($matrixPath, FILE_IGNORE_NEW_LINES);
if ($lines === false) {
    fwrite(STDERR, "[HOOK-TRACE-CONVENTION-CHECK] unable to read TRACEABILITY_MATRIX.md\n");
    exit(1);
}

$errors = [];
$checked = 0;
foreach ($lines as $line) {
    if (!str_starts_with($line, '| CRE8-')) continue;
    $cols = array_map('trim', explode('|', trim($line, "| \t")));
    if (count($cols) < 8) {
        continue;
    }
    [$reqId,,,$hookId,$mode,$tool,, $evidencePath] = $cols;
    $checked++;
    if ($reqId === '' || !str_starts_with($reqId, 'CRE8-')) $errors[] = "[HOOK-TRACE-CONVENTION-CHECK] invalid requirement_id in row: {$line}";
    if ($hookId === '' || !str_starts_with($hookId, 'HOOK-')) $errors[] = "[HOOK-TRACE-CONVENTION-CHECK] invalid hook_id for {$reqId}";
    if (!in_array($mode, ['automated','manual'], true)) $errors[] = "[HOOK-TRACE-CONVENTION-CHECK] invalid verification_mode for {$reqId}: {$mode}";
    if ($tool === '') $errors[] = "[HOOK-TRACE-CONVENTION-CHECK] missing tool/procedure for {$reqId}";
    if ($evidencePath === '' || $evidencePath === 'TBD') {
        $errors[] = "[HOOK-TRACE-CONVENTION-CHECK] missing evidence path for {$reqId}";
        continue;
    }
    $firstPath = trim(explode(';', $evidencePath)[0]);
    $firstPath = trim((string) preg_replace('/\s+/', '', $firstPath));
    if (str_starts_with($firstPath, 'composer')) {
        continue;
    }
}

if ($errors !== []) {
    foreach ($errors as $e) fwrite(STDERR, $e . PHP_EOL);
    exit(1);
}

echo "[HOOK-TRACE-CONVENTION-CHECK] PASS: {$checked} traceability rows validated for requirement↔hook↔evidence conventions." . PHP_EOL;
