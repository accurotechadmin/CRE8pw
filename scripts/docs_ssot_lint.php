<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$ssotRoot = $root . '/from_scratch/ssot_canon';
$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($ssotRoot));

$allMarkdown = [];
$basenameIndex = [];

foreach ($iter as $file) {
    if (!$file->isFile()) {
        continue;
    }

    $path = $file->getPathname();
    if (!str_ends_with($path, '.md')) {
        continue;
    }

    $allMarkdown[] = $path;
    $basenameIndex[basename($path)] = true;
}

$errors = [];

foreach ($allMarkdown as $path) {
    $contents = (string) file_get_contents($path);
    preg_match_all('/`([^`]+\.md)`/', $contents, $matches);

    foreach ($matches[1] as $ref) {
        $base = basename($ref);

        if (preg_match('/^(GET|POST|PATCH|DELETE|PUT)\s+\//', $ref) === 1) {
            continue;
        }

        if (!isset($basenameIndex[$base])) {
            $errors[] = [
                'file' => str_replace($root . '/', '', $path),
                'reference' => $ref,
            ];
        }
    }
}

if ($errors !== []) {
    fwrite(STDERR, "docs_ssot_lint_failed\n");
    fwrite(STDERR, json_encode(['errors' => $errors], JSON_PRETTY_PRINT) . "\n");
    exit(1);
}

echo "docs_ssot_lint_ok\n";
