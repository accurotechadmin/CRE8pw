<?php

declare(strict_types=1);

$commands = [
    'composer docs:ssot:lint',
    'composer docs:ssot:sync-check',
    'composer docs:ssot:report',
    'composer docs:ssot:trace-convention-check',
    'composer docs:ssot:command-registry-audit',
    'composer docs:ssot:route-parity',
    'composer docs:ssot:review-gate-check',
    'composer docs:ssot:phase2-exceptions-check',
    'composer test:contract:auth',
    'composer test:contract:feed',
    'composer test:contract:lifecycle',
    'composer test:contract:identity-issuance',
    'composer test:contract:identity-context',
    'composer test:contract:surface-parity',
];

$baselinePath = __DIR__ . '/../dev/implementation/PREEXISTING_FAILURE_BASELINE.json';
$baseline = [];
if (is_file($baselinePath)) {
    $parsed = json_decode((string) file_get_contents($baselinePath), true);
    if (is_array($parsed)) {
        foreach (($parsed['preexisting_failures'] ?? []) as $cmd) {
            if (is_string($cmd) && $cmd !== '') {
                $baseline[$cmd] = true;
            }
        }
    }
}

$failures = [];
foreach ($commands as $command) {
    fwrite(STDOUT, "[PHASE2-ACCEPTANCE] running: {$command}" . PHP_EOL);
    ob_start();
    passthru($command . ' 2>&1', $exitCode);
    $output = (string) ob_get_clean();
    echo $output;
    if ($exitCode !== 0) {
        $classification = isset($baseline[$command]) ? 'pre-existing issue' : 'introduced issue';
        $lower = strtolower($output);
        if (str_contains($lower, 'command not found') || str_contains($lower, 'could not resolve host') || str_contains($lower, 'permission denied')) {
            $classification = 'environment limitation';
        }
        $failures[] = ['command' => $command, 'exit_code' => $exitCode, 'classification' => $classification];
    }
}

if ($failures !== []) {
    fwrite(STDERR, '[PHASE2-ACCEPTANCE] FAILURE CLASSIFICATION SUMMARY' . PHP_EOL);
    foreach ($failures as $failure) {
        fwrite(STDERR, '[PHASE2-ACCEPTANCE] FAIL: ' . $failure['command'] . ' (exit=' . $failure['exit_code'] . '; ' . $failure['classification'] . ')' . PHP_EOL);
    }
    exit(1);
}

echo '[PHASE2-ACCEPTANCE] PASS: all bundle commands succeeded.' . PHP_EOL;
