<?php

declare(strict_types=1);

$root = dirname(__DIR__);
passthru('php ' . escapeshellarg($root . '/scripts/docs_ssot_requirement_inventory.php'), $code);
if ($code !== 0) {
    fwrite(STDERR, "[HOOK-TRACEABILITY-UNTRACED-REQUIREMENTS] FAIL unable to run inventory\n");
    exit(1);
}
$data = json_decode((string) file_get_contents($root . '/reports/ssot/requirement_inventory_latest.json'), true);
if (!is_array($data)) {
    fwrite(STDERR, "[HOOK-TRACEABILITY-UNTRACED-REQUIREMENTS] FAIL unable to parse inventory report\n");
    exit(1);
}
$baselineMax = 14;
$count = (int) ($data['untraced_requirements'] ?? 9999);
if ($count > $baselineMax) {
    fwrite(STDERR, "[HOOK-TRACEABILITY-UNTRACED-REQUIREMENTS] FAIL untraced={$count} exceeds baseline_max={$baselineMax}\n");
    exit(1);
}

echo "[HOOK-TRACEABILITY-UNTRACED-REQUIREMENTS] PASS untraced={$count} baseline_max={$baselineMax}\n";
