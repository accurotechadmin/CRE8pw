<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$gapPath = $repoRoot . '/docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md';
$trackerPath = $repoRoot . '/docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md';

$gapLines = file($gapPath, FILE_IGNORE_NEW_LINES);
$trackerLines = file($trackerPath, FILE_IGNORE_NEW_LINES);
if ($gapLines === false || $trackerLines === false) {
    fwrite(STDERR, "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] unable to read required gap/tracker docs" . PHP_EOL);
    exit(1);
}

preg_match_all('/\|\s*(SPR-\d{3})\s*\|/', implode("\n", $trackerLines), $trackerMatches);
$trackerRefs = array_flip(array_unique($trackerMatches[1]));

$tableHeader = '| gap_id | seed_requirement_ref | gap_class | proposed_target_slice | owner | status | resolution_due_utc | tracker_ref | notes |';
$headerIndex = array_search($tableHeader, $gapLines, true);
if ($headerIndex === false || !isset($gapLines[$headerIndex + 1]) || !str_starts_with(trim($gapLines[$headerIndex + 1]), '|---')) {
    fwrite(STDERR, "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] missing gap register table" . PHP_EOL);
    exit(1);
}

$allowedGapClasses = ['missing_doc', 'missing_requirement', 'verification_missing', 'conflict', 'deferred_scope'];
$allowedStatuses = ['open', 'in_progress', 'blocked', 'closed'];
$errors = [];
$rowCount = 0;

for ($i = $headerIndex + 2; $i < count($gapLines); $i++) {
    $line = trim($gapLines[$i]);
    if ($line === '' || !str_starts_with($line, '|')) {
        break;
    }

    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) !== 9) {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] invalid column count in row: {$line}";
        continue;
    }

    [$gapId, $seedRef, $gapClass, $targetSlice, $owner, $status, $dueUtc, $trackerRef] = $cols;
    $rowCount++;

    if (!preg_match('/^GAP-\d{3}$/', $gapId)) {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] {$gapId}: invalid gap_id format";
    }
    if ($seedRef === '' || !str_contains($seedRef, '#')) {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] {$gapId}: seed_requirement_ref must include path and anchor";
    }
    if (!in_array($gapClass, $allowedGapClasses, true)) {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] {$gapId}: invalid gap_class '{$gapClass}'";
    }
    if (!preg_match('/^S\d+$/', $targetSlice)) {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] {$gapId}: proposed_target_slice must match S#";
    }
    if ($owner === '') {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] {$gapId}: owner is required";
    }
    if (!in_array($status, $allowedStatuses, true)) {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] {$gapId}: invalid status '{$status}'";
    }
    if (DateTimeImmutable::createFromFormat('Y-m-d', $dueUtc) === false) {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] {$gapId}: invalid resolution_due_utc '{$dueUtc}'";
    }
    if ($trackerRef === '' || !isset($trackerRefs[$trackerRef])) {
        $errors[] = "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] {$gapId}: tracker_ref '{$trackerRef}' not found in SEED_PROMOTION_TRACKER.md";
    }
}

if ($rowCount === 0) {
    $errors[] = '[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] no gap rows found';
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo "[HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO] PASS: validated {$rowCount} unresolved seed gap rows." . PHP_EOL;
exit(0);
