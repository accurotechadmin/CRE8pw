<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$changedFiles = trim((string) shell_exec('git -C ' . escapeshellarg($repoRoot) . ' diff --name-only --diff-filter=ACMRTUXB HEAD'));
if ($changedFiles === '') {
    echo "[HOOK-REVIEW-GATE-CHECK-AUTO] PASS: no changed files detected." . PHP_EOL;
    exit(0);
}

$targets = array_values(array_filter(explode(PHP_EOL, $changedFiles), static function (string $path): bool {
    return str_starts_with($path, 'docs/') && str_ends_with($path, '.md');
}));

if ($targets === []) {
    echo "[HOOK-REVIEW-GATE-CHECK-AUTO] PASS: no changed docs/*.md files detected." . PHP_EOL;
    exit(0);
}

$errors = [];
foreach ($targets as $relativePath) {
    $fullPath = $repoRoot . '/' . $relativePath;
    $contents = file_get_contents($fullPath);
    if ($contents === false) {
        $errors[] = "[HOOK-REVIEW-GATE-CHECK-AUTO] {$relativePath}: unable to read file";
        continue;
    }

    if (!preg_match('/^status:\s*(normative|provisional-normative)\s*$/m', $contents)) {
        continue;
    }

    if (!preg_match('/^owner:\s*(.+)\s*$/m', $contents, $ownerMatch)) {
        $errors[] = "[HOOK-REVIEW-GATE-CHECK-AUTO] {$relativePath}: missing metadata key 'owner'";
        continue;
    }
    $owner = trim($ownerMatch[1]);

    if (!preg_match('/^reviewers:\s*\n((?:\s*-\s*.+\n)+)/m', $contents, $reviewerBlockMatch)) {
        $errors[] = "[HOOK-REVIEW-GATE-CHECK-AUTO] {$relativePath}: missing or empty reviewers list";
        continue;
    }

    preg_match_all('/^\s*-\s*(.+)\s*$/m', $reviewerBlockMatch[1], $reviewers);
    $reviewerList = array_map('trim', $reviewers[1]);
    $distinct = array_filter($reviewerList, static fn(string $r): bool => $r !== '' && strcasecmp($r, $owner) !== 0);
    if ($distinct === []) {
        $errors[] = "[HOOK-REVIEW-GATE-CHECK-AUTO] {$relativePath}: reviewers must include at least one entry distinct from owner";
    }

    $hasImpactMapRef = str_contains($contents, 'CHANGE_IMPACT_MAP_TEMPLATES.md') || str_contains($contents, 'Change Impact Map');
    if (!$hasImpactMapRef) {
        $errors[] = "[HOOK-REVIEW-GATE-CHECK-AUTO] {$relativePath}: missing change-impact map reference";
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo "[HOOK-REVIEW-GATE-CHECK-AUTO] PASS: changed normative docs satisfy owner/reviewer/impact-map checks." . PHP_EOL;
exit(0);
