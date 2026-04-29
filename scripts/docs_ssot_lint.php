<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$docsRoot = $repoRoot . '/docs';

$requiredMetadataKeys = [
    'doc_id',
    'version',
    'status',
    'owner',
    'reviewers',
    'last_reviewed_utc',
    'next_review_due_utc',
    'source_seed_refs',
    'normative_dependencies',
];
$prohibitedPhrases = [
    'This scaffold file defines',
    'structured placeholder',
];

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docsRoot));
$markdownFiles = [];
foreach ($it as $file) {
    if ($file->isFile() && strtolower($file->getExtension()) === 'md') {
        $markdownFiles[] = $file->getPathname();
    }
}

$errors = [];

foreach ($markdownFiles as $path) {
    $relativePath = ltrim(str_replace($repoRoot, '', $path), '/');
    $contents = file_get_contents($path);
    if ($contents === false) {
        $errors[] = "[HOOK-SSOT-LINT-METADATA] {$relativePath}: unable to read file";
        continue;
    }

    $isNormative = preg_match('/^status:\s*normative$/m', $contents) === 1
        || preg_match('/^status:\s*provisional-normative$/m', $contents) === 1;

    if ($isNormative) {
        foreach ($requiredMetadataKeys as $key) {
            if (preg_match('/^' . preg_quote($key, '/') . ':/m', $contents) !== 1) {
                $errors[] = "[HOOK-SSOT-LINT-METADATA] {$relativePath}: missing metadata key '{$key}'";
            }
        }

        foreach ($prohibitedPhrases as $phrase) {
            foreach (explode(PHP_EOL, $contents) as $line) {
                if (stripos($line, $phrase) === false) {
                    continue;
                }
                if (str_contains($line, 'rg "') || str_contains($line, '`')) {
                    continue;
                }
                $errors[] = "[HOOK-SSOT-LINT-SCAFFOLD-TEXT] {$relativePath}: contains prohibited phrase '{$phrase}'";
                break;
            }
        }
    }

    preg_match_all('/\[[^\]]+\]\(([^)]+)\)/', $contents, $linkMatches);
    $links = $linkMatches[1] ?? [];

    foreach ($links as $link) {
        if ($link === '' || str_starts_with($link, 'http://') || str_starts_with($link, 'https://') || str_starts_with($link, '#') || str_starts_with($link, 'mailto:')) {
            continue;
        }

        $linkNoAnchor = explode('#', $link)[0];
        if ($linkNoAnchor === '') {
            continue;
        }

        $target = realpath(dirname($path) . '/' . $linkNoAnchor);
        if ($target === false || !file_exists($target)) {
            $errors[] = "[HOOK-SSOT-LINK-INTEGRITY] {$relativePath}: unresolved link '{$link}'";
        }
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'docs:ssot:lint PASS' . PHP_EOL;
exit(0);
