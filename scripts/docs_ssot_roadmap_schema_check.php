<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$roadmapPath = $repoRoot . '/docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md';

$lines = file($roadmapPath, FILE_IGNORE_NEW_LINES);
if ($lines === false) {
    fwrite(STDERR, "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] unable to read ROADMAP_AND_MILESTONES.md" . PHP_EOL);
    exit(1);
}

$tableHeader = '| slice_id | status | owner | target_date_utc | date_commitment_type | notes |';
$headerIndex = array_search($tableHeader, $lines, true);
if ($headerIndex === false || !isset($lines[$headerIndex + 1]) || !str_starts_with(trim($lines[$headerIndex + 1]), '|---')) {
    fwrite(STDERR, "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] missing phase baseline milestones table" . PHP_EOL);
    exit(1);
}

$allowedStatuses = ['not_started', 'in_progress', 'partially_complete', 'complete', 'blocked'];
$allowedCommitments = ['target', 'committed'];
$errors = [];
$rowCount = 0;

for ($i = $headerIndex + 2; $i < count($lines); $i++) {
    $line = trim($lines[$i]);
    if ($line === '' || !str_starts_with($line, '|')) {
        break;
    }

    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) !== 6) {
        $errors[] = "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] invalid column count in row: {$line}";
        continue;
    }

    [$sliceId, $status, $owner, $targetDateUtc, $commitmentType] = $cols;
    $rowCount++;

    if (!preg_match('/^S\d+$/', $sliceId)) {
        $errors[] = "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] {$sliceId}: invalid slice_id format (expected S#)";
    }
    if (!in_array($status, $allowedStatuses, true)) {
        $errors[] = "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] {$sliceId}: invalid status '{$status}'";
    }
    if ($owner === '') {
        $errors[] = "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] {$sliceId}: owner is required";
    }
    $isDateValid = DateTimeImmutable::createFromFormat('Y-m-d', $targetDateUtc) !== false;
    if (!$isDateValid) {
        $errors[] = "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] {$sliceId}: invalid target_date_utc '{$targetDateUtc}' (expected YYYY-MM-DD)";
    }
    if (!in_array($commitmentType, $allowedCommitments, true)) {
        $errors[] = "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] {$sliceId}: invalid date_commitment_type '{$commitmentType}'";
    }
}

if ($rowCount === 0) {
    $errors[] = '[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] no slice rows found in baseline milestones table';
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo "[HOOK-TRACE-ROADMAP-SCHEMA-AUTO] PASS: validated {$rowCount} roadmap slice rows." . PHP_EOL;
exit(0);
