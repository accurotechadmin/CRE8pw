<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$docsRoot = $repoRoot . '/docs';
$matrixPath = $repoRoot . '/docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md';
$outPath = $repoRoot . '/reports/ssot/coverage_latest.json';

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docsRoot));
$requirements = [];
foreach ($it as $file) {
    if (!$file->isFile() || strtolower($file->getExtension()) !== 'md') {
        continue;
    }
    $contents = file_get_contents($file->getPathname());
    if ($contents === false) {
        continue;
    }
    preg_match_all('/CRE8-[A-Z0-9-]+-REQ-\d{4}/', $contents, $matches);
    foreach ($matches[0] as $reqId) {
        $requirements[$reqId] = true;
    }
}

$matrix = file_get_contents($matrixPath) ?: '';
$traced = [];
foreach (array_keys($requirements) as $reqId) {
    if (str_contains($matrix, $reqId)) {
        $traced[$reqId] = true;
    }
}

preg_match_all('/\|\s*CRE8-[^|]+\|[^\n]*\|\s*manual\s*\|/i', $matrix, $manualRows);
$report = [
    'generated_at_utc' => gmdate('c'),
    'total_normative_requirements' => count($requirements),
    'traced_requirements' => count($traced),
    'untraced_requirements' => count($requirements) - count($traced),
    'manual_only_verification_hooks' => count($manualRows[0] ?? []),
];

if (!is_dir(dirname($outPath))) {
    mkdir(dirname($outPath), 0775, true);
}
file_put_contents($outPath, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);

echo "docs:ssot:report PASS ({$outPath})" . PHP_EOL;
exit(0);
