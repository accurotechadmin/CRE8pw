<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$traceabilityPath = $repoRoot . '/docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md';

$changedFiles = trim((string) shell_exec('git -C ' . escapeshellarg($repoRoot) . ' diff --name-only --diff-filter=ACMRTUXB HEAD'));
if ($changedFiles === '') {
    echo "[HOOK-DOD-TRACE-CHECK-AUTO] PASS: no changed files detected." . PHP_EOL;
    exit(0);
}

$targets = array_values(array_filter(explode(PHP_EOL, $changedFiles), static function (string $path): bool {
    return str_starts_with($path, 'docs/')
        && str_ends_with($path, '.md')
        && $path !== 'docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md';
}));

if ($targets === []) {
    echo "[HOOK-DOD-TRACE-CHECK-AUTO] PASS: no changed docs/*.md files requiring trace cross-check." . PHP_EOL;
    exit(0);
}

$traceability = file($traceabilityPath, FILE_IGNORE_NEW_LINES);
if ($traceability === false) {
    fwrite(STDERR, "[HOOK-DOD-TRACE-CHECK-AUTO] unable to read traceability matrix" . PHP_EOL);
    exit(1);
}

$matrix = [];
foreach ($traceability as $line) {
    if (!str_starts_with(trim($line), '| CRE8-')) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 3) {
        continue;
    }
    $reqId = $cols[0];
    $sourcePath = $cols[2];
    $matrix[$reqId][] = $sourcePath;
}

$errors = [];
foreach ($targets as $relativePath) {
    $fullPath = $repoRoot . '/' . $relativePath;
    $contents = file_get_contents($fullPath);
    if ($contents === false) {
        $errors[] = "[HOOK-DOD-TRACE-CHECK-AUTO] {$relativePath}: unable to read file";
        continue;
    }

    preg_match_all('/\*\*\s*(CRE8-[A-Z0-9]+-REQ-\d{4})\s*\*\*/', $contents, $reqMatches);
    $reqIds = array_unique($reqMatches[1]);

    foreach ($reqIds as $reqId) {
        if (!isset($matrix[$reqId])) {
            $errors[] = "[HOOK-DOD-TRACE-CHECK-AUTO] {$relativePath}: requirement '{$reqId}' missing from TRACEABILITY_MATRIX.md";
            continue;
        }
        if (!in_array($relativePath, $matrix[$reqId], true)) {
            $errors[] = "[HOOK-DOD-TRACE-CHECK-AUTO] {$relativePath}: requirement '{$reqId}' traced to different source_path(s): " . implode(', ', $matrix[$reqId]);
        }
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo "[HOOK-DOD-TRACE-CHECK-AUTO] PASS: changed requirement IDs are traceability-mapped." . PHP_EOL;
exit(0);
