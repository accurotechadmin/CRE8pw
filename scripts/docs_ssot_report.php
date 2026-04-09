<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$outDir = $root . '/from_scratch/ssot_canon/evidence/automation';
@mkdir($outDir, 0777, true);

$commands = [
    'lint' => 'php ' . escapeshellarg($root . '/scripts/docs_ssot_lint.php'),
    'sync_check' => 'php ' . escapeshellarg($root . '/scripts/docs_ssot_sync_check.php'),
];

$results = [];
$allOk = true;

foreach ($commands as $name => $cmd) {
    $output = [];
    $exitCode = 0;
    exec($cmd . ' 2>&1', $output, $exitCode);

    $results[$name] = [
        'command' => $cmd,
        'exit_code' => $exitCode,
        'output' => $output,
    ];

    if ($exitCode !== 0) {
        $allOk = false;
    }
}

$report = [
    'generated_at_utc' => gmdate('c'),
    'status' => $allOk ? 'ok' : 'failed',
    'checks' => $results,
];

$file = $outDir . '/ssot_report.json';
file_put_contents($file, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");

echo 'docs_ssot_report_' . ($allOk ? 'ok' : 'failed') . ':' . $file . "\n";
exit($allOk ? 0 : 1);
