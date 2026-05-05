<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/Application/CryptoPolicy.php';
require dirname(__DIR__) . '/src/Application/KeyLifecycleLedger.php';
require dirname(__DIR__) . '/src/Application/SecurityHeaderPolicy.php';

use Cre8\Application\CryptoPolicy;
use Cre8\Application\KeyLifecycleLedger;
use Cre8\Application\SecurityHeaderPolicy;

$weak = ['memory_cost' => 32768, 'time_cost' => 2, 'threads' => 1];
if (CryptoPolicy::isArgon2idProfileCompliant($weak)) {
    fwrite(STDERR, '[HOOK-SEC-CRYPTO-PROFILE] weak Argon2id profile must be rejected' . PHP_EOL);
    exit(1);
}

$strong = ['memory_cost' => 65536, 'time_cost' => 3, 'threads' => 1];
if (!CryptoPolicy::isArgon2idProfileCompliant($strong)) {
    fwrite(STDERR, '[HOOK-SEC-CRYPTO-PROFILE] baseline Argon2id profile must pass' . PHP_EOL);
    exit(1);
}

$ledger = new KeyLifecycleLedger();
$ledger->issue('uk_1', 'actor_owner_1');
$ledger->suspend('uk_1', 'actor_owner_1');
$ledger->rotate('uk_1', 'uk_2', 'actor_owner_1');
$ledger->revoke('uk_2', 'actor_owner_1');
if ($ledger->stateOf('uk_1') !== 'rotated' || $ledger->stateOf('uk_2') !== 'revoked') {
    fwrite(STDERR, '[HOOK-SEC-LIFECYCLE-PROPAGATION] lifecycle terminal states drifted' . PHP_EOL);
    exit(1);
}
if (count($ledger->events()) < 5) {
    fwrite(STDERR, '[HOOK-SEC-AUDIT-IMMUTABILITY] expected lifecycle audit events to be emitted' . PHP_EOL);
    exit(1);
}

$ownerHeaders = SecurityHeaderPolicy::forSurface('owner_console', 'nonce123');
foreach (['Strict-Transport-Security', 'X-Content-Type-Options', 'X-Frame-Options', 'Content-Security-Policy'] as $required) {
    if (!isset($ownerHeaders[$required])) {
        fwrite(STDERR, '[HOOK-SEC-HEADERS-CSP] missing required owner_console header: ' . $required . PHP_EOL);
        exit(1);
    }
}
if (!str_contains((string) $ownerHeaders['Content-Security-Policy'], "default-src 'self'")) {
    fwrite(STDERR, '[HOOK-SEC-HEADERS-CSP] CSP default-src self requirement missing' . PHP_EOL);
    exit(1);
}

echo 'test:contract:security-controls PASS (crypto_profile=validated, lifecycle_events=validated, headers_csp=validated)' . PHP_EOL;
