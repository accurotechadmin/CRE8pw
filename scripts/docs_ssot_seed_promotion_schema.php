<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$trackerPath = $repoRoot . '/docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md';

$lines = file($trackerPath, FILE_IGNORE_NEW_LINES);
if ($lines === false) {
    fwrite(STDERR, "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] unable to read SEED_PROMOTION_TRACKER.md" . PHP_EOL);
    exit(1);
}

$tableHeader = '| tracker_ref | seed_requirement_ref | target_doc_id | target_requirement_id | promotion_status | verification_hook_id | decision_ref | notes |';
$headerIndex = array_search($tableHeader, $lines, true);
if ($headerIndex === false || !isset($lines[$headerIndex + 1]) || !str_starts_with(trim($lines[$headerIndex + 1]), '|---')) {
    fwrite(STDERR, "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] missing promotion tracker table" . PHP_EOL);
    exit(1);
}

$allowedStatuses = ['candidate', 'drafted', 'reviewed', 'promoted', 'deferred', 'retired'];
$trackerRefs = [];
$errors = [];
$rowCount = 0;

for ($i = $headerIndex + 2; $i < count($lines); $i++) {
    $line = trim($lines[$i]);
    if ($line === '' || !str_starts_with($line, '|')) {
        break;
    }

    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) !== 8) {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] invalid column count in row: {$line}";
        continue;
    }

    [$trackerRef, $seedRef, $targetDocId, $targetReqId, $status, $hookId, $decisionRef] = $cols;
    $rowCount++;

    if (!preg_match('/^SPR-\d{3}$/', $trackerRef)) {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] {$trackerRef}: invalid tracker_ref format";
    }
    if (isset($trackerRefs[$trackerRef])) {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] {$trackerRef}: duplicate tracker_ref";
    }
    $trackerRefs[$trackerRef] = true;

    if ($seedRef === '' || !str_contains($seedRef, '#')) {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] {$trackerRef}: seed_requirement_ref must include path and anchor";
    }
    if ($targetDocId === '') {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] {$trackerRef}: target_doc_id is required";
    }
    if (!in_array($status, $allowedStatuses, true)) {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] {$trackerRef}: invalid promotion_status '{$status}'";
    }
    if ($hookId === '' || !str_starts_with($hookId, 'HOOK-')) {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] {$trackerRef}: verification_hook_id must start with HOOK-";
    }

    if ($status === 'promoted' && ($targetReqId === '' || $targetReqId === 'TBD')) {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] {$trackerRef}: promoted rows require non-TBD target_requirement_id";
    }
    if (in_array($status, ['deferred', 'retired'], true) && $decisionRef === '') {
        $errors[] = "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] {$trackerRef}: {$status} rows require decision_ref";
    }
}

if ($rowCount === 0) {
    $errors[] = '[HOOK-SEED-PROMOTION-SCHEMA-AUTO] no tracker rows found';
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo "[HOOK-SEED-PROMOTION-SCHEMA-AUTO] PASS: validated {$rowCount} seed promotion tracker rows." . PHP_EOL;
exit(0);
