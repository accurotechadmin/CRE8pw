<?php

declare(strict_types=1);

$commands = [
    'composer docs:ssot:lint',
    'composer docs:ssot:sync-check',
    'composer docs:ssot:report',
    'composer test:contract:auth',
    'composer test:contract:error',
    'composer test:contract:auth-reasons',
    'composer test:contract:feed',
];

foreach ($commands as $command) {
    fwrite(STDOUT, sprintf("\n=== Running: %s ===\n", $command));
    passthru($command, $exitCode);

    if ($exitCode !== 0) {
        fwrite(STDERR, sprintf("Acceptance bundle failed at command: %s (exit %d)\n", $command, $exitCode));
        exit($exitCode);
    }
}

fwrite(STDOUT, "\nPhase 1 acceptance bundle completed successfully.\n");
