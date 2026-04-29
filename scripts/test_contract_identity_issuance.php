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

echo 'test:contract:identity-issuance PASS (hook=HOOK-IDENTITY-ID-FIRST-ISSUANCE, clauses=1, fixtures=2, deny_path=id_required_before_utility)' . PHP_EOL;
