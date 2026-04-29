<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$trackerPath = $repoRoot . '/docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md';
$gapPath = $repoRoot . '/docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md';
$matrixPath = $repoRoot . '/docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md';
$manualBacklogPath = $repoRoot . '/reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md';

$tracker = file_get_contents($trackerPath);
$gapRegister = file_get_contents($gapPath);
$matrix = file_get_contents($matrixPath);
$manualBacklog = file_get_contents($manualBacklogPath);
if ($tracker === false || $gapRegister === false || $matrix === false || $manualBacklog === false) {
    fwrite(STDERR, "[HOOK-SSOT-SYNC] unable to read tracker, gap register, matrix, or manual backlog" . PHP_EOL);
    exit(1);
}

function parseMarkdownTableRows(string $markdown, string $headerToken): array
{
    $rows = [];
    $lines = explode("\n", $markdown);

    $inTargetTable = false;
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '') {
            if ($inTargetTable) {
                break;
            }
            continue;
        }

        if (str_contains($trimmed, $headerToken)) {
            $inTargetTable = true;
            continue;
        }

        if (!$inTargetTable) {
            continue;
        }

        if (!str_starts_with($trimmed, '|')) {
            break;
        }

        if (preg_match('/^\|\s*---/', $trimmed) === 1) {
            continue;
        }

        $rows[] = array_map('trim', explode('|', trim($trimmed, '|')));
    }

    return $rows;
}

$trackerRows = parseMarkdownTableRows($tracker, '| tracker_ref | seed_requirement_ref |');
$gapRows = parseMarkdownTableRows($gapRegister, '| gap_id | seed_requirement_ref |');
$manualBacklogRows = parseMarkdownTableRows($manualBacklog, '| hook_id | source requirement(s) |');

$trackerRefs = [];
$trackerByRef = [];
foreach ($trackerRows as $cols) {
    if (count($cols) < 8) {
        continue;
    }

    $row = [
        'tracker_ref' => $cols[0],
        'seed_requirement_ref' => $cols[1],
        'target_doc_id' => $cols[2],
        'target_requirement_id' => $cols[3],
        'promotion_status' => $cols[4],
        'verification_hook_id' => $cols[5],
    ];

    if ($row['tracker_ref'] === '' || $row['tracker_ref'] === 'tracker_ref') {
        continue;
    }

    $trackerRefs[$row['tracker_ref']] = true;
    $trackerByRef[$row['tracker_ref']] = $row;
}

$errors = [];
$promotedChecked = 0;
foreach ($trackerByRef as $row) {
    if ($row['promotion_status'] !== 'promoted') {
        continue;
    }

    $promotedChecked++;
    $targetReq = $row['target_requirement_id'];
    if ($targetReq === '' || $targetReq === 'TBD') {
        $errors[] = "[HOOK-SSOT-SYNC-PROMOTED-TARGET] {$row['tracker_ref']}: promoted row has invalid target requirement";
        continue;
    }

    $docsRoot = $repoRoot . '/docs';
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docsRoot));
    $foundRequirement = false;
    foreach ($it as $docPath) {
        if (!$docPath->isFile() || strtolower($docPath->getExtension()) !== 'md') {
            continue;
        }
        $contents = file_get_contents($docPath->getPathname());
        if ($contents !== false && str_contains($contents, $targetReq)) {
            $foundRequirement = true;
            break;
        }
    }

    if (!$foundRequirement) {
        $errors[] = "[HOOK-SSOT-SYNC-PROMOTED-TARGET] {$row['tracker_ref']}: target requirement '{$targetReq}' not found";
    }

    if (!str_contains($matrix, $targetReq)) {
        $errors[] = "[HOOK-SSOT-SYNC-PROMOTED-TRACE] {$row['tracker_ref']}: requirement '{$targetReq}' missing in traceability matrix";
    }
}

$gapRefsChecked = 0;
foreach ($gapRows as $cols) {
    if (count($cols) < 8) {
        continue;
    }

    $gapId = $cols[0];
    $status = $cols[5];
    $trackerRef = $cols[7];

    if ($gapId === '' || $gapId === 'gap_id') {
        continue;
    }

    if ($status === 'closed') {
        continue;
    }

    $gapRefsChecked++;
    if ($trackerRef === '' || !isset($trackerRefs[$trackerRef])) {
        $errors[] = "[HOOK-SEED-GAP-TRACKER-SYNC] {$gapId}: tracker_ref '{$trackerRef}' missing from seed promotion tracker";
    }
}


$requiredAutomatedHooks = [
    'HOOK-SEC-LIFECYCLE-PROPAGATION',
    'HOOK-EXT-SEAM-COMPATIBILITY',
];
foreach ($requiredAutomatedHooks as $hookId) {
    $pattern = '/\|\s*[^|]+\s*\|\s*[^|]+\s*\|\s*[^|]+\s*\|\s*' . preg_quote($hookId, '/') . '\s*\|\s*([^|]+)\|/';
    if (preg_match($pattern, $matrix, $m) !== 1) {
        $errors[] = "[HOOK-SSOT-SYNC-AUTOMATION] {$hookId}: missing traceability matrix row";
        continue;
    }
    if (trim($m[1]) !== 'automated') {
        $errors[] = "[HOOK-SSOT-SYNC-AUTOMATION] {$hookId}: verification_mode must be automated";
    }
}

$manualHooksInBacklog = [];
foreach ($manualBacklogRows as $cols) {
    if (count($cols) < 7) {
        continue;
    }

    $hookId = $cols[0];
    if ($hookId === '' || $hookId === 'hook_id') {
        continue;
    }

    $owner = $cols[2] ?? '';
    $priority = $cols[3] ?? '';
    $currentMode = $cols[4] ?? '';
    $targetCommand = $cols[6] ?? '';
    if ($owner === '' || $priority === '' || $targetCommand === '') {
        $errors[] = "[HOOK-SSOT-MANUAL-BACKLOG-LINK] {$hookId}: backlog row must include owner, priority, and target command/script";
    }
    if ($currentMode !== 'manual') {
        $errors[] = "[HOOK-SSOT-MANUAL-BACKLOG-LINK] {$hookId}: current mode must be 'manual'";
    }

    $manualHooksInBacklog[$hookId] = true;
}

$matrixRows = parseMarkdownTableRows($matrix, '| requirement_id | source_doc_id | source_path | verification_hook_id | verification_mode | owner | status | evidence_location |');
$manualRowsChecked = 0;
foreach ($matrixRows as $cols) {
    if (count($cols) < 8) {
        continue;
    }

    $requirementId = $cols[0];
    $hookId = $cols[3];
    $verificationMode = $cols[4];

    if ($requirementId === '' || $requirementId === 'requirement_id') {
        continue;
    }

    if ($verificationMode !== 'manual') {
        continue;
    }

    $manualRowsChecked++;
    if (!isset($manualHooksInBacklog[$hookId])) {
        $errors[] = "[HOOK-SSOT-MANUAL-BACKLOG-LINK] {$requirementId}: manual hook '{$hookId}' missing from PHASE1_MANUAL_HOOK_BACKLOG.md";
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo "docs:ssot:sync-check PASS (promoted_rows_checked={$promotedChecked}, gap_refs_checked={$gapRefsChecked}, manual_backlog_link_rows_checked={$manualRowsChecked})" . PHP_EOL;
exit(0);
