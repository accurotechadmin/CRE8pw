#!/usr/bin/env php
<?php

declare(strict_types=1);

$doc = __DIR__ . '/../docs/60_operations_quality_and_release/RELEASE_CHECKLIST.md';
$content = file_get_contents($doc) ?: '';
$required = ['RG-01','RG-02','RG-03','RG-04','RG-05','gate_id','executed_utc','operator_id'];
foreach ($required as $needle) {
    if (!str_contains($content, $needle)) {
        fwrite(STDERR, "[HOOK-RELEASE-CHECKLIST-PRESENT] FAIL missing {$needle}\n");
        exit(1);
    }
}
echo "[HOOK-RELEASE-CHECKLIST-PRESENT] PASS\n";
