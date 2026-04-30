#!/usr/bin/env php
<?php

declare(strict_types=1);

$checks = [
    [
        'name' => 'migration_dir_present',
        'status' => is_dir(__DIR__ . '/../migrations') ? 'pass' : 'warn',
        'detail' => 'migrations/',
    ],
    [
        'name' => 'pdo_extension_loaded',
        'status' => extension_loaded('pdo') ? 'pass' : 'fail',
        'detail' => 'ext-pdo',
    ],
];

$hasFailure = false;
foreach ($checks as $check) {
    if ($check['status'] === 'fail') {
        $hasFailure = true;
        break;
    }
}

$result = [
    'command' => 'ops:migrate-smoke',
    'status' => $hasFailure ? 'fail' : 'pass',
    'checks' => $checks,
    'notes' => [
        'warn status indicates advisory-only findings for this smoke check.',
    ],
];

fwrite(STDOUT, json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);
exit($hasFailure ? 1 : 0);
