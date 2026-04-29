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


$ssotIndexPath = $docsRoot . '/00_governance/SSOT_INDEX.md';
$readmePath = $repoRoot . '/README.md';
$relativeDocSet = [];
foreach ($markdownFiles as $docPath) {
    $relativeDocSet[] = ltrim(str_replace($repoRoot, '', $docPath), '/');
}

$linkGraph = [];
foreach ($markdownFiles as $path) {
    $relativeSourcePath = ltrim(str_replace($repoRoot, '', $path), '/');
    $contents = file_get_contents($path);
    if ($contents === false) {
        continue;
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
            continue;
        }
        $relativeTargetPath = ltrim(str_replace($repoRoot, '', $target), '/');
        if (!str_ends_with($relativeTargetPath, '.md')) {
            continue;
        }
        if (!array_key_exists($relativeTargetPath, $linkGraph)) {
            $linkGraph[$relativeTargetPath] = [];
        }
        $linkGraph[$relativeTargetPath][] = $relativeSourcePath;
    }
}

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



$readmeContents = file_get_contents($readmePath);
$readmeHasSsotLink = false;
if ($readmeContents !== false) {
    preg_match_all('/\[[^\]]+\]\(([^)]+)\)/', $readmeContents, $readmeLinkMatches);
    foreach (($readmeLinkMatches[1] ?? []) as $readmeLink) {
        if ($readmeLink === '' || str_starts_with($readmeLink, 'http://') || str_starts_with($readmeLink, 'https://') || str_starts_with($readmeLink, '#') || str_starts_with($readmeLink, 'mailto:')) {
            continue;
        }
        $linkNoAnchor = explode('#', $readmeLink)[0];
        if ($linkNoAnchor === '') {
            continue;
        }
        $target = realpath($repoRoot . '/' . $linkNoAnchor);
        if ($target === false) {
            continue;
        }
        $relativeTargetPath = ltrim(str_replace($repoRoot, '', $target), '/');
        if ($relativeTargetPath === 'docs/00_governance/SSOT_INDEX.md') {
            $readmeHasSsotLink = true;
            break;
        }
    }
}
if (!$readmeHasSsotLink) {
    $errors[] = '[HOOK-SSOT-LINK-TOPOLOGY] README.md: missing required vertical link to docs/00_governance/SSOT_INDEX.md';
}

$ssotContents = file_get_contents($ssotIndexPath);
if ($ssotContents === false) {
    $errors[] = '[HOOK-SSOT-LINK-TOPOLOGY] docs/00_governance/SSOT_INDEX.md: unable to read required topology anchor';
} else {
    foreach ($relativeDocSet as $relativeDocPath) {
        $docContents = file_get_contents($repoRoot . '/' . $relativeDocPath);
        if ($docContents === false) {
            continue;
        }

        $hasRequirements = preg_match('/CRE8-[A-Z0-9]+-REQ-[0-9]{4}/', $docContents) === 1;
        if (!$hasRequirements) {
            continue;
        }

        if (!str_starts_with($relativeDocPath, 'docs/')) {
            continue;
        }

        if (str_starts_with($relativeDocPath, 'docs/00_governance/')) {
            continue;
        }

        $hasInbound = array_key_exists($relativeDocPath, $linkGraph);
        if (!$hasInbound) {
            $errors[] = "[HOOK-SSOT-ANTI-ORPHAN-CHECK] {$relativeDocPath}: missing inbound documentation link";
            continue;
        }

        $hasQualifiedInbound = false;
        foreach ($linkGraph[$relativeDocPath] as $sourcePath) {
            if (str_starts_with($sourcePath, 'docs/00_governance/SSOT_INDEX.md')) {
                $hasQualifiedInbound = true;
                break;
            }
            if (preg_match('#^docs/[0-9]{2}_[^/]+/#', $sourcePath) === 1 && dirname($sourcePath) === dirname($relativeDocPath)) {
                $hasQualifiedInbound = true;
                break;
            }
        }

        if (!$hasQualifiedInbound) {
            $errors[] = "[HOOK-SSOT-ANTI-ORPHAN-CHECK] {$relativeDocPath}: inbound link exists but not from SSOT index or same-domain doc";
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
