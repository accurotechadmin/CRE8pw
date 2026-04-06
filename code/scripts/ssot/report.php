<?php

declare(strict_types=1);

require_once __DIR__ . '/Support/ssot_lib.php';

$reportDir = ssot_code_root_dir() . '/build/ssot';
$lintFile = $reportDir . '/lint.json';
$syncFile = $reportDir . '/sync_check.json';

$lint = file_exists($lintFile) ? json_decode((string) file_get_contents($lintFile), true) : null;
$sync = file_exists($syncFile) ? json_decode((string) file_get_contents($syncFile), true) : null;

$lintIssueCount = is_array($lint) ? (int) ($lint['issue_count'] ?? 0) : null;
$syncIssueCount = is_array($sync)
    ? (int) (($sync['counts']['missing_in_openapi'] ?? 0) + ($sync['counts']['missing_in_inventory'] ?? 0))
    : null;

$blocksMerge = ($lintIssueCount ?? 1) > 0 || ($syncIssueCount ?? 1) > 0;

$payload = [
    'check' => 'report',
    'generated_at_utc' => gmdate(DATE_ATOM),
    'inputs' => [
        'lint_json' => $lintFile,
        'sync_check_json' => $syncFile,
    ],
    'summary' => [
        'lint_issue_count' => $lintIssueCount,
        'sync_issue_count' => $syncIssueCount,
        'merge_blocked' => $blocksMerge,
    ],
    'passed' => !$blocksMerge,
];

ssot_write_json_report('report.json', $payload);

fwrite(STDOUT, "[ssot-report] Lint report: " . (file_exists($lintFile) ? 'present' : 'missing') . "\n");
fwrite(STDOUT, "[ssot-report] Sync report: " . (file_exists($syncFile) ? 'present' : 'missing') . "\n");
fwrite(STDOUT, '[ssot-report] Lint issue count: ' . ($lintIssueCount === null ? 'unknown' : (string) $lintIssueCount) . "\n");
fwrite(STDOUT, '[ssot-report] Sync issue count: ' . ($syncIssueCount === null ? 'unknown' : (string) $syncIssueCount) . "\n");
fwrite(STDOUT, '[ssot-report] Merge blocked: ' . ($blocksMerge ? 'yes' : 'no') . "\n");
fwrite(STDOUT, "[ssot-report] JSON report: code/build/ssot/report.json\n");

if ($blocksMerge) {
    fwrite(STDOUT, "[ssot-report] FAIL: SSOT automation checks are not clean.\n");
    exit(1);
}

fwrite(STDOUT, "[ssot-report] PASS\n");
exit(0);
