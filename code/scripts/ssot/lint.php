<?php

declare(strict_types=1);

require_once __DIR__ . '/Support/ssot_lib.php';

$ssotRoot = ssot_default_root_dir();
$metadataIssues = ssot_check_markdown_metadata($ssotRoot);
$linkIssues = ssot_check_markdown_links($ssotRoot);

$issues = [
    'metadata' => $metadataIssues,
    'cross_references' => $linkIssues,
];

$totalIssueCount = count($metadataIssues) + count($linkIssues);
$payload = [
    'check' => 'lint',
    'generated_at_utc' => gmdate(DATE_ATOM),
    'ssot_root' => $ssotRoot,
    'issue_count' => $totalIssueCount,
    'issues' => $issues,
    'passed' => $totalIssueCount === 0,
];

ssot_write_json_report('lint.json', $payload);

fwrite(STDOUT, "[ssot-lint] SSOT root: {$ssotRoot}\n");
fwrite(STDOUT, "[ssot-lint] Metadata issues: " . count($metadataIssues) . "\n");
fwrite(STDOUT, "[ssot-lint] Cross-reference issues: " . count($linkIssues) . "\n");
fwrite(STDOUT, "[ssot-lint] JSON report: code/build/ssot/lint.json\n");

if ($totalIssueCount > 0) {
    fwrite(STDOUT, "[ssot-lint] FAIL: Found {$totalIssueCount} issue(s).\n");
    exit(1);
}

fwrite(STDOUT, "[ssot-lint] PASS\n");
exit(0);
