<?php

declare(strict_types=1);

$commands = [
    'composer docs:ssot:lint',
    'composer docs:ssot:sync-check',
    'composer docs:ssot:report',
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

$failures = [];
foreach ($commands as $command) {
    fwrite(STDOUT, "[PHASE2-ACCEPTANCE] running: {$command}" . PHP_EOL);
    passthru($command, $exitCode);
    if ($exitCode !== 0) {
        $failures[] = [
            'command' => $command,
            'exit_code' => $exitCode,
        ];
    }
}

if ($failures !== []) {
    foreach ($failures as $failure) {
        fwrite(STDERR, '[PHASE2-ACCEPTANCE] FAIL: ' . $failure['command'] . ' (exit=' . $failure['exit_code'] . ')' . PHP_EOL);
    }
    exit(1);
}

echo '[PHASE2-ACCEPTANCE] PASS: all bundle commands succeeded.' . PHP_EOL;
