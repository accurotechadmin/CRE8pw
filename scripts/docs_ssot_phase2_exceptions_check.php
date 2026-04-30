<?php

declare(strict_types=1);

$registerPath = __DIR__ . '/../docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md';
$decisionsPath = __DIR__ . '/../docs/80_traceability_decisions_and_program/DECISIONS_LOG.md';
$adrIndexPath = __DIR__ . '/../docs/80_traceability_decisions_and_program/ADR_INDEX.md';
$progressBoardPath = __DIR__ . '/../reports/session_handoffs/PHASE2_PROGRESS_BOARD.md';

foreach ([$registerPath, $decisionsPath, $adrIndexPath, $progressBoardPath] as $requiredPath) {
    if (!is_file($requiredPath)) {
        fwrite(STDERR, "[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] missing file: {$requiredPath}\n");
        exit(1);
    }
}

$register = file_get_contents($registerPath);
$decisions = file_get_contents($decisionsPath);
$adrIndex = file_get_contents($adrIndexPath);
$progressBoard = file_get_contents($progressBoardPath);
if ($register === false || $decisions === false || $adrIndex === false || $progressBoard === false) {
    fwrite(STDERR, "[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] failed to read one or more required artifacts.\n");
    exit(1);
}

$lines = preg_split('/\R/', $register) ?: [];
$rows = [];
$inTable = false;
foreach ($lines as $line) {
    if (str_starts_with($line, '## Current unresolved exceptions')) {
        $inTable = true;
        continue;
    }
    if ($inTable && str_starts_with($line, '## ')) {
        break;
    }
    if ($inTable && str_starts_with(trim($line), '| P2-EXC-')) {
        $rows[] = $line;
    }
}

if ($rows === []) {
    fwrite(STDERR, "[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] no exception rows found.\n");
    exit(1);
}

$errors = [];
$allowedStatus = ['open', 'in_progress', 'blocked', 'closed'];
foreach ($rows as $row) {
    $cells = array_map('trim', explode('|', trim($row, '|')));
    if (count($cells) < 11) {
        $errors[] = "malformed row: {$row}";
        continue;
    }

    [$id, , , $status, $due, $decision, $hooks, $nextCommand, $evidence, $linkedItemId] = $cells;

    if (!preg_match('/^P2-EXC-\d{3}$/', $id)) {
        $errors[] = "invalid exception_id {$id}";
    }
    if (!in_array($status, $allowedStatus, true)) {
        $errors[] = "invalid status {$status} for {$id}";
    }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $due)) {
        $errors[] = "invalid due_utc {$due} for {$id}";
    }
    if (!preg_match('/^(ADR-\d{3}|DECISION-\d{8}-\d{3})$/', $decision)) {
        $errors[] = "invalid decision_ref {$decision} for {$id}";
    }
    if ($hooks === '') {
        $errors[] = "missing verification_hook_ids for {$id}";
    }
    if (in_array($status, ['open', 'blocked'], true) && $nextCommand === '') {
        $errors[] = "missing next_command for {$id} with status {$status}";
    }
    if ($status === 'closed' && $evidence === '') {
        $errors[] = "closed row {$id} must include evidence_paths";
    }

    if (str_starts_with($decision, 'ADR-') && !str_contains($adrIndex, "| {$decision} |")) {
        $errors[] = "decision_ref {$decision} for {$id} not found in ADR_INDEX.md";
    }
    if (str_starts_with($decision, 'DECISION-') && !preg_match('/\|\s*' . preg_quote($decision, '/') . '\s*\|/', $decisions)) {
        $errors[] = "decision_ref {$decision} for {$id} not found in DECISIONS_LOG.md";
    }

    if ($status === 'closed') {
        if ($linkedItemId === '') {
            $errors[] = "closed row {$id} must include linked_item_id";
        } elseif (!preg_match('/\|\s*' . preg_quote($linkedItemId, '/') . '\s*\|.*\|\s*complete\s*\|/i', $progressBoard)) {
            $errors[] = "closed row {$id} linked_item_id {$linkedItemId} not marked complete in PHASE2_PROGRESS_BOARD.md";
        }
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, "[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] FAIL: {$error}\n");
    }
    exit(1);
}

echo '[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] PASS: register schema and linkage validated.' . PHP_EOL;
