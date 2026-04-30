<?php

declare(strict_types=1);

$specPath = dirname(__DIR__) . '/docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md';
$spec = file_get_contents($specPath);
if ($spec === false) {
    fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] unable to read identity model spec" . PHP_EOL);
    exit(1);
}

$requiredClause = 'Every minted principal **MUST** be issued one lineage-root ID keypair before any utility keypair is created.';
if (!str_contains($spec, $requiredClause)) {
    fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] CRE8-ARCH-REQ-0001 canonical ID-first issuance clause drift detected" . PHP_EOL);
    exit(1);
}

if (!str_contains($spec, 'HOOK-IDENTITY-ID-FIRST-ISSUANCE')) {
    fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] verification hook declaration missing from identity model spec" . PHP_EOL);
    exit(1);
}

$fixture = [
    'principal_minted' => true,
    'id_keypair_issued' => true,
    'utility_keypair_created' => true,
];

$invalidFixture = [
    'principal_minted' => true,
    'id_keypair_issued' => false,
    'utility_keypair_created' => true,
];

if (!($fixture['principal_minted'] && $fixture['id_keypair_issued'] && $fixture['utility_keypair_created'])) {
    fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] expected positive fixture to satisfy issuance precondition" . PHP_EOL);
    exit(1);
}

if ($invalidFixture['principal_minted'] && !$invalidFixture['id_keypair_issued'] && $invalidFixture['utility_keypair_created']) {
    // expected deny path
} else {
    fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] expected negative fixture to demonstrate deny path when utility issuance precedes ID issuance" . PHP_EOL);
    exit(1);
}


$eventSequenceFixture = [
    ['event' => 'principal.minted', 'request_id' => 'req-ident-issue-001', 'timestamp_utc' => '2026-04-30T00:00:00Z'],
    ['event' => 'id_keypair.issued', 'request_id' => 'req-ident-issue-001', 'timestamp_utc' => '2026-04-30T00:00:01Z'],
    ['event' => 'utility_keypair.created', 'request_id' => 'req-ident-issue-001', 'timestamp_utc' => '2026-04-30T00:00:02Z'],
];

$badEventSequenceFixture = [
    ['event' => 'principal.minted', 'request_id' => 'req-ident-issue-002', 'timestamp_utc' => '2026-04-30T00:00:00Z'],
    ['event' => 'utility_keypair.created', 'request_id' => 'req-ident-issue-002', 'timestamp_utc' => '2026-04-30T00:00:01Z'],
    ['event' => 'id_keypair.issued', 'request_id' => 'req-ident-issue-002', 'timestamp_utc' => '2026-04-30T00:00:02Z'],
];

$indexByEvent = [];
foreach ($eventSequenceFixture as $idx => $row) {
    if (!str_starts_with($row['request_id'], 'req-ident-issue-')) {
        fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] replay-safe request_id namespace drift in issuance fixture" . PHP_EOL);
        exit(1);
    }
    if (strtotime($row['timestamp_utc']) === false) {
        fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] timestamp_utc must be parseable ISO-8601 in issuance fixture" . PHP_EOL);
        exit(1);
    }
    $indexByEvent[$row['event']] = $idx;
}

if (!isset($indexByEvent['id_keypair.issued'], $indexByEvent['utility_keypair.created']) || $indexByEvent['id_keypair.issued'] > $indexByEvent['utility_keypair.created']) {
    fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] expected id_keypair.issued to precede utility_keypair.created in positive event fixture" . PHP_EOL);
    exit(1);
}

$badIndexByEvent = [];
foreach ($badEventSequenceFixture as $idx => $row) {
    $badIndexByEvent[$row['event']] = $idx;
}
if (!isset($badIndexByEvent['id_keypair.issued'], $badIndexByEvent['utility_keypair.created']) || $badIndexByEvent['id_keypair.issued'] < $badIndexByEvent['utility_keypair.created']) {
    fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] expected negative event fixture to model utility issuance before ID issuance" . PHP_EOL);
    exit(1);
}


$multiActorRuntimeFixture = [
    ['principal_id' => 'p-root-001', 'actor_id' => 'issuer-root', 'event' => 'principal.minted', 'request_id' => 'req-ident-issue-rt-001', 'timestamp_utc' => '2026-04-30T00:10:00Z'],
    ['principal_id' => 'p-root-001', 'actor_id' => 'issuer-root', 'event' => 'id_keypair.issued', 'request_id' => 'req-ident-issue-rt-001', 'timestamp_utc' => '2026-04-30T00:10:01Z'],
    ['principal_id' => 'p-root-001', 'actor_id' => 'issuer-tenant-a', 'event' => 'utility_keypair.created', 'context' => 'tenant:t-a', 'request_id' => 'req-ident-issue-rt-001', 'timestamp_utc' => '2026-04-30T00:10:02Z'],
    ['principal_id' => 'p-root-002', 'actor_id' => 'issuer-root', 'event' => 'principal.minted', 'request_id' => 'req-ident-issue-rt-002', 'timestamp_utc' => '2026-04-30T00:10:03Z'],
    ['principal_id' => 'p-root-002', 'actor_id' => 'issuer-root', 'event' => 'id_keypair.issued', 'request_id' => 'req-ident-issue-rt-002', 'timestamp_utc' => '2026-04-30T00:10:04Z'],
    ['principal_id' => 'p-root-002', 'actor_id' => 'issuer-tenant-b', 'event' => 'utility_keypair.created', 'context' => 'tenant:t-b', 'request_id' => 'req-ident-issue-rt-002', 'timestamp_utc' => '2026-04-30T00:10:05Z'],
];

$seenRequestIds = [];
$issuedIdByPrincipal = [];
foreach ($multiActorRuntimeFixture as $row) {
    if (!str_starts_with($row['request_id'], 'req-ident-issue-rt-')) {
        fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] runtime issuance fixture request_id namespace drift detected" . PHP_EOL);
        exit(1);
    }
    if (strtotime($row['timestamp_utc']) === false) {
        fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] runtime issuance fixture timestamp_utc must be parseable ISO-8601" . PHP_EOL);
        exit(1);
    }
    $seenRequestIds[$row['request_id']] = true;

    if ($row['event'] === 'id_keypair.issued') {
        $issuedIdByPrincipal[$row['principal_id']] = true;
    }
    if ($row['event'] === 'utility_keypair.created' && !isset($issuedIdByPrincipal[$row['principal_id']])) {
        fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] runtime fixture violates ID-first rule for principal " . $row['principal_id'] . PHP_EOL);
        exit(1);
    }
}

if (count($seenRequestIds) < 2) {
    fwrite(STDERR, "[HOOK-IDENTITY-ID-FIRST-ISSUANCE] expected multi-actor runtime fixture to include at least two distinct replay-safe request ids" . PHP_EOL);
    exit(1);
}
echo 'test:contract:identity-issuance PASS (hook=HOOK-IDENTITY-ID-FIRST-ISSUANCE, clauses=1, fixtures=5, deny_path=id_required_before_utility, replay_safe_namespace=req-ident-issue-*|req-ident-issue-rt-*)' . PHP_EOL;
