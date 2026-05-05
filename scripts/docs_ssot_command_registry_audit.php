<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$composer = json_decode((string) file_get_contents($repoRoot . '/composer.json'), true);
$scripts = $composer['scripts'] ?? [];

$required = [
    'docs:ssot:lint','docs:ssot:sync-check','docs:ssot:report','docs:ssot:route-parity','docs:ssot:route-uniqueness',
    'docs:ssot:compat-declaration','docs:ssot:error-code-coverage','docs:ssot:deprecation-schema','docs:ssot:review-gate-check',
    'docs:ssot:dod-trace-check','docs:ssot:roadmap-schema-check','docs:ssot:seed-promotion-schema','docs:ssot:seed-gap-schema',
    'docs:ssot:glossary-check','docs:ssot:phase2-exceptions-check','phase2:acceptance-bundle','phase3:final-acceptance-bundle'
];
$missing = [];
foreach ($required as $cmd) if (!array_key_exists($cmd, $scripts)) $missing[] = $cmd;
if ($missing !== []) {
    foreach ($missing as $m) fwrite(STDERR, "[HOOK-COMMAND-REGISTRY-AUDIT] missing composer script: {$m}\n");
    exit(1);
}
echo '[HOOK-COMMAND-REGISTRY-AUDIT] PASS: required hook commands are registered in composer.json.' . PHP_EOL;
