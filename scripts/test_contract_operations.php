#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../src/Application/OperationalReadiness.php';
require __DIR__ . '/../src/Application/StartupConfiguration.php';

use Cre8\Application\OperationalReadiness;
use Cre8\Application\StartupConfiguration;

$ops = new OperationalReadiness();
$live = $ops->liveness('req-health-live-001');
if (($live['data']['status'] ?? null) !== 'live') {
    fwrite(STDERR, "[HOOK-OPS-HEALTH-LIVENESS] expected status=live\n"); exit(1);
}

$readyOk = $ops->readiness('req-health-ready-001', [
    ['name' => 'config_loaded', 'status' => 'pass'],
    ['name' => 'persistence_connectivity', 'status' => 'pass'],
    ['name' => 'crypto_provider', 'status' => 'pass'],
]);
if (($readyOk['data']['status'] ?? null) !== 'ready') {
    fwrite(STDERR, "[HOOK-OPS-HEALTH-READINESS] expected status=ready\n"); exit(1);
}

$readyFail = $ops->readiness('req-health-ready-002', [
    ['name' => 'config_loaded', 'status' => 'fail', 'dsn' => 'mysql://root:secret@localhost/db'],
]);
if (($readyFail['error']['code'] ?? null) !== 'SYSTEM_DEPENDENCY_UNREADY') {
    fwrite(STDERR, "[HOOK-CONTRACT-ERROR-DETERMINISM] expected SYSTEM_DEPENDENCY_UNREADY\n"); exit(1);
}
if (str_contains(json_encode($readyFail, JSON_THROW_ON_ERROR), 'secret')) {
    fwrite(STDERR, "[HOOK-CONTRACT-ERROR-SECRETS-REDACTION] readiness leaked secret\n"); exit(1);
}

$cfg = new StartupConfiguration();
$ok = $cfg->validate([
    'CRE8_ENV' => 'dev',
    'CRE8_DB_DSN' => 'sqlite::memory:',
    'CRE8_AUTH_JWT_ISSUER' => 'cre8',
    'CRE8_AUTH_JWT_AUDIENCE' => 'cre8-clients',
    'CRE8_AUTH_CLOCK_SKEW_SEC' => '120',
]);
if (!$ok['ok']) {
    fwrite(STDERR, "[HOOK-OPS-STARTUP-CONFIG] expected valid configuration\n"); exit(1);
}

$bad = $cfg->validate(['CRE8_ENV' => 'dev']);
if (($bad['code'] ?? null) !== 'SYSTEM_STARTUP_FAILED') {
    fwrite(STDERR, "[HOOK-OPS-STARTUP-FAIL-CLOSED] expected SYSTEM_STARTUP_FAILED\n"); exit(1);
}

echo "test:contract:operations PASS (health=validated, startup_config=validated)\n";
