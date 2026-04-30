<?php

declare(strict_types=1);

$path = __DIR__ . '/../docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md';
if (!is_file($path)) {
    fwrite(STDERR, "[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] missing file: {$path}\n");
    exit(1);
}

$content = file_get_contents($path);
if ($content === false) {
    fwrite(STDERR, "[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] failed to read register.\n");
    exit(1);
}

$lines = preg_split('/\R/', $content) ?: [];
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
    if (count($cells) < 10) {
        $errors[] = "malformed row: {$row}";
        continue;
    }

    [$id, , , $status, $due, $decision, $hooks, $nextCommand, $evidence] = $cells;

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
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, "[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] FAIL: {$error}\n");
    }
    exit(1);
}

echo '[HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA] PASS: register schema validated.' . PHP_EOL;
