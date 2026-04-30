<?php
declare(strict_types=1);

$commands = [
    'docs:ssot:sync-check',
    'docs:ssot:report',
    'docs:ssot:route-parity',
    'docs:ssot:openapi-lint',
    'docs:ssot:schema-coverage',
    'docs:ssot:example-coverage',
    'docs:ssot:glossary-check',
    'docs:ssot:source-refs-check',
    'docs:ssot:permission-vocab-resolve',
    'docs:ssot:capability-matrix-complete',
    'docs:ssot:delegation-sm-consistency',
    'docs:ssot:data-model-coverage',
    'docs:ssot:threat-control-matrix',
    'docs:ssot:event-catalog-coverage',
    'docs:ssot:compat-declaration',
];

foreach ($commands as $command) {
    $full = sprintf('composer %s', $command);
    fwrite(STDOUT, sprintf("[P3-DRIFT] running: %s\n", $full));
    passthru($full, $exitCode);

    if ($exitCode !== 0) {
        fwrite(STDERR, sprintf("[P3-DRIFT] FAIL: %s exited with %d\n", $full, $exitCode));
        exit($exitCode);
    }
}

fwrite(STDOUT, "[P3-DRIFT] PASS: all phase3 drift checks succeeded.\n");
