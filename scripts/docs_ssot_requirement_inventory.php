<?php
declare(strict_types=1);
$repoRoot = dirname(__DIR__);
$docsRoot = $repoRoot . '/docs';
$matrixPath = $repoRoot . '/docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md';
$requirements = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docsRoot));
foreach ($it as $file) {
    if (!$file->isFile() || strtolower($file->getExtension()) !== 'md') { continue; }
    $contents = file_get_contents($file->getPathname());
    if ($contents === false) { continue; }
    preg_match('/^doc_id:\s*(.+)$/m', $contents, $docMatch);
    $docId = $docMatch[1] ?? 'UNKNOWN';
    preg_match_all('/CRE8-[A-Z0-9-]+-REQ-\d{4}/', $contents, $reqMatch);
    foreach (array_unique($reqMatch[0]) as $reqId) {
        $requirements[$reqId] = ['doc_id'=>$docId,'path'=>str_replace($repoRoot.'/', '', $file->getPathname())];
    }
}
ksort($requirements);
$matrix = file_get_contents($matrixPath) ?: '';
$untraced = [];
foreach ($requirements as $reqId => $meta) {
    if (!str_contains($matrix, $reqId)) { $untraced[$reqId] = $meta; }
}
$out = ['generated_at_utc'=>gmdate('c'),'total_requirements'=>count($requirements),'untraced_requirements'=>count($untraced),'untraced'=>$untraced];
$outPath = $repoRoot . '/reports/ssot/requirement_inventory_latest.json';
if (!is_dir(dirname($outPath))) { mkdir(dirname($outPath), 0775, true); }
file_put_contents($outPath, json_encode($out, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . PHP_EOL);
echo "docs:ssot:requirement-inventory PASS ({$outPath})" . PHP_EOL;
