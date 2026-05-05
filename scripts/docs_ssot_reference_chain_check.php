<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$changed = trim((string) shell_exec('git -C ' . escapeshellarg($repoRoot) . ' diff --name-only --diff-filter=ACMRTUXB HEAD'));
if ($changed === '') {
    echo "[HOOK-SSOT-REFERENCE-CHAIN] PASS: no changed files detected." . PHP_EOL;
    exit(0);
}

$changedPaths = array_values(array_filter(explode(PHP_EOL, $changed)));
$structural = false;
foreach ($changedPaths as $path) {
    if (
        str_starts_with($path, 'docs/') ||
        str_starts_with($path, 'dev/') ||
        str_starts_with($path, 'seed/') ||
        str_starts_with($path, 'reports/') ||
        $path === 'README.md' ||
        $path === 'composer.json'
    ) {
        $structural = true;
        break;
    }
}

if (!$structural) {
    echo "[HOOK-SSOT-REFERENCE-CHAIN] PASS: no reference-scoped structural files changed." . PHP_EOL;
    exit(0);
}

$requiredFiles = [
    'FILE_INVENTORY.md',
    'master_index.md',
];

$missing = [];
foreach ($requiredFiles as $required) {
    if (!in_array($required, $changedPaths, true)) {
        $missing[] = $required;
    }
}

if ($missing !== []) {
    fwrite(STDERR, '[HOOK-SSOT-REFERENCE-CHAIN] structural change detected but missing required updates: ' . implode(', ', $missing) . PHP_EOL);
    exit(1);
}

echo "[HOOK-SSOT-REFERENCE-CHAIN] PASS: required global reference chain files updated." . PHP_EOL;
exit(0);
