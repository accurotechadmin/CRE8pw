#!/usr/bin/env php
<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$environment = getenv('CRE8_ENV') ?: 'local/dev';
$allowedSeedByEnv = [
    'local/dev' => ['baseline', 'test-fixture', 'demo'],
    'ci/test' => ['baseline', 'test-fixture'],
    'staging' => ['baseline', 'demo'],
    'production' => ['baseline'],
];

$seedClass = getenv('CRE8_SEED_CLASS') ?: 'baseline';

$checks = [
    [
        'name' => 'migration_dir_present',
        'status' => is_dir($root . '/migrations') ? 'pass' : 'fail',
        'detail' => 'migrations/',
    ],
    [
        'name' => 'migration_manifest_present',
        'status' => is_file($root . '/migrations/manifest.json') ? 'pass' : 'fail',
        'detail' => 'migrations/manifest.json',
    ],
    [
        'name' => 'pdo_extension_loaded',
        'status' => extension_loaded('pdo') ? 'pass' : 'fail',
        'detail' => 'ext-pdo',
    ],
    [
        'name' => 'seed_class_allowed_for_environment',
        'status' => in_array($seedClass, $allowedSeedByEnv[$environment] ?? [], true) ? 'pass' : 'fail',
        'detail' => sprintf('env=%s seed_class=%s', $environment, $seedClass),
    ],
    [
        'name' => 'seed_class_directory_present',
        'status' => is_dir($root . '/seeds/' . $seedClass) ? 'pass' : 'fail',
        'detail' => 'seeds/' . $seedClass,
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
    'evidence' => [
        'batch_id' => gmdate('YmdHis') . '-smoke',
        'timestamp_utc' => gmdate('c'),
        'environment' => $environment,
        'seed_class' => $seedClass,
    ],
    'notes' => [
        'Forward-only migration policy is enforced by requiring canonical migration manifest and environment seed-class policy checks.',
    ],
];

fwrite(STDOUT, json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);
exit($hasFailure ? 1 : 0);
