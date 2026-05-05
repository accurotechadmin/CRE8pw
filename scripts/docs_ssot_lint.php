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
    'This scaffold file defines the authoritative scope, boundaries, and eventual normative obligations for',
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


function parseYamlList(string $contents, string $key): array
{
    $pattern = '/^' . preg_quote($key, '/') . ':\s*
((?:\s{2,}-\s.*
)+)/m';
    if (preg_match($pattern, $contents, $matches) !== 1) {
        return [];
    }
    $lines = preg_split('/
/', trim($matches[1]));
    $items = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if (preg_match('/^-\s*(.+)$/', $line, $m) === 1) {
            $items[] = trim($m[1]);
        }
    }
    return $items;
}

$ssotIndexPath = $docsRoot . '/00_governance/SSOT_INDEX.md';
$readmePath = $repoRoot . '/README.md';
$relativeDocSet = [];
foreach ($markdownFiles as $docPath) {
    $relativeDocSet[] = ltrim(str_replace($repoRoot, '', $docPath), '/');
}

/**
 * Resolve a markdown link target path to an absolute filesystem path.
 * Tries resolution relative to the source file directory first, then relative to the repository root.
 * For bare `*.md` filenames, resolves a unique path under `docs/` when exactly one match exists.
 */
function resolveMarkdownLinkTarget(string $repoRoot, string $sourcePath, string $link): ?string
{
    $linkNoAnchor = explode('#', $link)[0];
    if ($linkNoAnchor === '') {
        return null;
    }

    $relativeBaseCandidates = [dirname($sourcePath), $repoRoot];
    foreach ($relativeBaseCandidates as $base) {
        $candidate = realpath($base . '/' . $linkNoAnchor);
        if ($candidate !== false && file_exists($candidate)) {
            return $candidate;
        }
    }

    if (str_contains($linkNoAnchor, '/') || str_contains($linkNoAnchor, '\\')) {
        return null;
    }
    if (!str_ends_with(strtolower($linkNoAnchor), '.md')) {
        return null;
    }

    $docsRoot = $repoRoot . '/docs';
    if (!is_dir($docsRoot)) {
        return null;
    }

    $matches = [];
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docsRoot));
    /** @var SplFileInfo $file */
    foreach ($it as $file) {
        if (!$file->isFile()) {
            continue;
        }
        if (strcasecmp($file->getFilename(), $linkNoAnchor) !== 0) {
            continue;
        }
        $matches[] = $file->getPathname();
    }

    if (count($matches) !== 1) {
        return null;
    }

    $resolved = realpath($matches[0]);
    return $resolved !== false ? $resolved : null;
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
        $target = resolveMarkdownLinkTarget($repoRoot, $path, $link);
        if ($target === null || !file_exists($target)) {
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

    $domainRules = [
        'docs/00_governance/' => ['owner' => 'Docs Governance WG', 'reviewers' => ['Platform Architecture WG'], 'security_optional' => 'Security WG'],
        'docs/10_product_and_architecture/' => ['owner' => 'Platform Architecture WG', 'reviewers' => ['Docs Governance WG', 'Delivery Operations WG']],
        'docs/20_identity_delegation_and_policy/' => ['owner' => 'Platform Architecture WG', 'reviewers' => ['Security WG', 'Docs Governance WG']],
        'docs/30_contracts_and_interfaces/' => ['owner' => 'Platform Architecture WG', 'reviewers' => ['Delivery Operations WG', 'Docs Governance WG']],
        'docs/31_machine_contracts/' => ['owner' => 'Platform Architecture WG', 'reviewers' => ['Delivery Operations WG', 'Security WG']],
        'docs/40_data_security_and_crypto/' => ['owner' => 'Security WG', 'reviewers' => ['Platform Architecture WG', 'Docs Governance WG']],
        'docs/50_content_audience_and_feed/' => ['owner' => 'Product Policy WG', 'reviewers' => ['Platform Architecture WG', 'Security WG']],
        'docs/60_operations_quality_and_release/' => ['owner' => 'Operations Quality WG', 'reviewers' => ['Delivery Operations WG', 'Platform Architecture WG']],
        'docs/70_extensibility_and_module_patterns/' => ['owner' => 'Platform Architecture WG', 'reviewers' => ['Security WG', 'Docs Governance WG']],
        'docs/80_traceability_decisions_and_program/' => ['owner' => 'Program Traceability WG', 'reviewers' => ['Docs Governance WG', 'Delivery Operations WG']],
        'docs/evidence/' => ['owner' => 'Operations Quality WG', 'reviewers' => ['Program Traceability WG', 'Docs Governance WG']],
    ];

    $isNormative = preg_match('/^status:\s*normative$/m', $contents) === 1
        || preg_match('/^status:\s*provisional-normative$/m', $contents) === 1;

    if ($isNormative) {
        foreach ($requiredMetadataKeys as $key) {
            if (preg_match('/^' . preg_quote($key, '/') . ':/m', $contents) !== 1) {
                $errors[] = "[HOOK-SSOT-LINT-METADATA] {$relativePath}: missing metadata key '{$key}'";
            }
        }


        $owner = '';
        if (preg_match('/^owner:\s*(.+)$/m', $contents, $ownerMatch) === 1) {
            $owner = trim($ownerMatch[1]);
        }
        $reviewers = parseYamlList($contents, 'reviewers');

        foreach ($domainRules as $prefix => $rule) {
            if (!str_starts_with($relativePath, $prefix)) {
                continue;
            }
            $hasDistinctReviewer = false;
            foreach ($reviewers as $reviewer) {
                if ($reviewer !== '' && $reviewer !== $owner) {
                    $hasDistinctReviewer = true;
                    break;
                }
            }
            if (!$hasDistinctReviewer) {
                $errors[] = "[HOOK-SSOT-REVIEWER-ASSIGNMENT] {$relativePath}: must include at least one reviewer distinct from owner";
            }
            break;
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

        $target = resolveMarkdownLinkTarget($repoRoot, $path, $link);
        if ($target === null || !file_exists($target)) {
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
