<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$trackerPath = $repoRoot . '/docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md';
$matrixPath = $repoRoot . '/docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md';

$tracker = file_get_contents($trackerPath);
$matrix = file_get_contents($matrixPath);
if ($tracker === false || $matrix === false) {
    fwrite(STDERR, "[HOOK-SSOT-SYNC-PROMOTED-TARGET] unable to read tracker or matrix" . PHP_EOL);
    exit(1);
}

$rows = [];
foreach (explode("\n", $tracker) as $line) {
    if (!str_starts_with(trim($line), '| seed/')) {
        continue;
    }

    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 7) {
        continue;
    }

    $rows[] = [
        'seed_requirement_ref' => $cols[0],
        'target_doc_id' => $cols[1],
        'target_requirement_id' => $cols[2],
        'promotion_status' => $cols[3],
        'verification_hook_id' => $cols[4],
    ];
}

$errors = [];
$checked = 0;
foreach ($rows as $row) {
    if ($row['promotion_status'] !== 'promoted') {
        continue;
    }
    $checked++;

    $targetReq = $row['target_requirement_id'];
    if ($targetReq === '' || $targetReq === 'TBD') {
        $errors[] = "[HOOK-SSOT-SYNC-PROMOTED-TARGET] {$row['seed_requirement_ref']}: promoted row has invalid target requirement";
        continue;
    }

    $docsRoot = $repoRoot . '/docs';
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docsRoot));
    $foundRequirement = false;
    foreach ($it as $docPath) {
        if (!$docPath->isFile() || strtolower($docPath->getExtension()) !== 'md') {
            continue;
        }
        $contents = file_get_contents($docPath);
        if ($contents !== false && str_contains($contents, $targetReq)) {
            $foundRequirement = true;
            break;
        }
    }
    if (!$foundRequirement) {
        $errors[] = "[HOOK-SSOT-SYNC-PROMOTED-TARGET] {$row['seed_requirement_ref']}: target requirement '{$targetReq}' not found";
    }

    if (!str_contains($matrix, $targetReq)) {
        $errors[] = "[HOOK-SSOT-SYNC-PROMOTED-TRACE] {$row['seed_requirement_ref']}: requirement '{$targetReq}' missing in traceability matrix";
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo "docs:ssot:sync-check PASS (promoted_rows_checked={$checked})" . PHP_EOL;
exit(0);
