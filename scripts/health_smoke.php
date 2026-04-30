#!/usr/bin/env php
<?php

declare(strict_types=1);

$checks = [
    [
        'name' => 'php_version',
        'status' => PHP_VERSION_ID >= 80505 ? 'pass' : 'fail',
        'detail' => PHP_VERSION,
    ],
    [
        'name' => 'composer_json_present',
        'status' => is_file(__DIR__ . '/../composer.json') ? 'pass' : 'fail',
        'detail' => 'composer.json',
    ],
];

$hasFailure = false;
foreach ($checks as $check) {
    if ($check['status'] !== 'pass') {
        $hasFailure = true;
        break;
    }
}

$result = [
    'command' => 'ops:health-smoke',
    'status' => $hasFailure ? 'fail' : 'pass',
    'checks' => $checks,
];

fwrite(STDOUT, json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);
exit($hasFailure ? 1 : 0);
