<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$latestPointerPath = $repoRoot . '/reports/session_handoffs/LATEST_SESSION_HANDOFF.md';

$latestPointer = file_get_contents($latestPointerPath);
if ($latestPointer === false) {
    fwrite(STDERR, "[HOOK-SSOT-PR-EVIDENCE-REQUIRED] unable to read LATEST_SESSION_HANDOFF.md" . PHP_EOL);
    exit(1);
}

if (!preg_match('/Latest handoff:\s*`([^`]+)`/', $latestPointer, $match)) {
    fwrite(STDERR, "[HOOK-SSOT-PR-EVIDENCE-REQUIRED] latest handoff pointer missing required path format" . PHP_EOL);
    exit(1);
}

$handoffRelPath = $match[1];
$handoffPath = $repoRoot . '/' . $handoffRelPath;
$handoff = file_get_contents($handoffPath);
if ($handoff === false) {
    fwrite(STDERR, "[HOOK-SSOT-PR-EVIDENCE-REQUIRED] cannot read referenced handoff: {$handoffRelPath}" . PHP_EOL);
    exit(1);
}

$requiredCommands = [
    'composer docs:ssot:lint',
    'composer docs:ssot:sync-check',
    'composer docs:ssot:report',
];

$missing = [];
foreach ($requiredCommands as $command) {
    if (!str_contains($handoff, "`{$command}`") || !preg_match('/`' . preg_quote($command, '/') . '`\s+(PASS|FAIL|WARNING|✅|❌|⚠️)/u', $handoff)) {
        $missing[] = $command;
    }
}

if (!str_contains($handoff, 'Verification commands + outcomes:') && !str_contains($handoff, '## 4) Verified checks run')) {
    fwrite(STDERR, "[HOOK-SSOT-PR-EVIDENCE-REQUIRED] handoff missing explicit verification section" . PHP_EOL);
    exit(1);
}

if ($missing !== []) {
    fwrite(STDERR, '[HOOK-SSOT-PR-EVIDENCE-REQUIRED] missing command outcome evidence in latest handoff: ' . implode(', ', $missing) . PHP_EOL);
    exit(1);
}

echo 'docs:ssot:pr-evidence-check PASS (handoff=' . $handoffRelPath . ', required_commands_checked=' . count($requiredCommands) . ')' . PHP_EOL;
exit(0);
