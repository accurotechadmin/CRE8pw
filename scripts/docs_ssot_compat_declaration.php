<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$apiGuidePath = $repoRoot . '/docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md';
$apiGuide = file_get_contents($apiGuidePath);
if ($apiGuide === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-COMPAT-DECLARATION] unable to read API contract guide" . PHP_EOL);
    exit(1);
}

$requiredPhrases = [
    'backward-compatibility classification (`compatible`, `conditionally-compatible`, `breaking`)',
    'migration notes before merge',
    'Route deprecation **MUST** include a documented sunset date, replacement route reference, and a verification-plan update.',
];

$errors = [];
foreach ($requiredPhrases as $phrase) {
    if (strpos($apiGuide, $phrase) === false) {
        $errors[] = '[HOOK-CONTRACT-COMPAT-DECLARATION] missing required compatibility declaration clause: ' . $phrase;
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'docs:ssot:compat-declaration PASS (clauses=' . count($requiredPhrases) . ')' . PHP_EOL;
