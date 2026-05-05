#!/usr/bin/env php
<?php

declare(strict_types=1);

$doc = __DIR__ . '/../docs/60_operations_quality_and_release/SLO_SLI_SPEC.md';
$content = file_get_contents($doc) ?: '';
$required = ['latency','availability','error rate','lifecycle propagation latency','audit completeness ratio','API Gateway','PDP lifecycle'];
foreach ($required as $needle) {
    if (stripos($content, $needle) === false) {
        fwrite(STDERR, "[HOOK-SLO-SLI-PRESENT] FAIL missing {$needle}\n");
        exit(1);
    }
}
echo "[HOOK-SLO-SLI-PRESENT] PASS\n";
