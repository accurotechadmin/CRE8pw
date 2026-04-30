#!/usr/bin/env php
<?php
declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$glossaryPath = $repoRoot . '/docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md';

if (!is_file($glossaryPath)) {
    fwrite(STDERR, "[docs:ssot:glossary-check] Missing glossary: {$glossaryPath}\n");
    exit(1);
}

$glossary = file_get_contents($glossaryPath);
preg_match_all('/\|\s*`([^`]+)`\s*\|/', $glossary, $matches);
$terms = array_unique(array_map(static fn(string $t): string => strtolower(trim($t)), $matches[1]));

if (count($terms) < 50) {
    fwrite(STDERR, "[docs:ssot:glossary-check] Expected at least 50 glossary terms; found " . count($terms) . "\n");
    exit(1);
}

$required = [
    'owner','primary author','secondary author','use principal','id keypair','utility keypair','keychain',
    'audience group','owner console','api gateway','public/bootstrap surface','policy decision point',
    'provenance event','delegation depth','scope','deny','allow','decision reason code','cursor','feed item'
];

$missing = [];
foreach ($required as $need) {
    if (!in_array(strtolower($need), $terms, true)) {
        $missing[] = $need;
    }
}

if ($missing !== []) {
    fwrite(STDERR, "[docs:ssot:glossary-check] Missing required glossary terms: " . implode(', ', $missing) . "\n");
    exit(1);
}

echo "[docs:ssot:glossary-check] PASS: " . count($terms) . " terms; required canonical terms present.\n";
