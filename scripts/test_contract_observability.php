#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../src/Application/SecurityEventEmitter.php';

use Cre8\Application\SecurityEventEmitter;

$emitter = new SecurityEventEmitter();
$emitter->emit('authz.decision.evaluated.v1', 'req-obs-1', [
    'principal_id' => 'principal-1',
    'keypair_id' => 'kp-1',
    'delegation_id' => 'del-1',
    'signature' => 'abc',
]);
$emitter->emit('authz.decision.denied.v1', 'req-obs-2', [
    'principal_id' => 'principal-2',
    'token' => 'opaque',
]);
$events = $emitter->events();

foreach ($events as $event) {
    foreach (['event_name','event_version','severity','channel','sampling','retention','timestamp_utc','request_id'] as $field) {
        if (!array_key_exists($field, $event)) {
            fwrite(STDERR, "missing required event field={$field}\n");
            exit(1);
        }
    }
}

$json = json_encode($events, JSON_THROW_ON_ERROR);
if (str_contains($json, 'opaque') || str_contains($json, 'abc')) {
    fwrite(STDERR, "secret-adjacent fields must be redacted\n");
    exit(1);
}

echo "test:contract:observability PASS (catalog fields + redaction enforced)\n";
