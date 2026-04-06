<?php

declare(strict_types=1);

function ssot_repo_root(): string
{
    return realpath(__DIR__ . '/../../../../') ?: __DIR__;
}

function ssot_default_root_dir(): string
{
    return ssot_repo_root() . '/docs/SSOT';
}

function ssot_code_root_dir(): string
{
    return ssot_repo_root() . '/code';
}

/**
 * @return array{status:string,last_updated:string}
 */
function ssot_extract_metadata(string $markdown): array
{
    $status = '';
    $lastUpdated = '';

    if (preg_match('/_Status:\s*([^_]+)_/m', $markdown, $matches) === 1) {
        $status = trim($matches[1]);
    }

    if (preg_match('/_Last updated \(UTC\):\s*([^_]+)_/m', $markdown, $matches) === 1) {
        $lastUpdated = trim($matches[1]);
    }

    return [
        'status' => $status,
        'last_updated' => $lastUpdated,
    ];
}

/**
 * @return array<int,array{file:string,issue:string,hint:string}>
 */
function ssot_check_markdown_metadata(string $ssotRoot): array
{
    $issues = [];

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($ssotRoot, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $item) {
        if (!$item instanceof SplFileInfo || $item->getExtension() !== 'md') {
            continue;
        }

        $contents = file_get_contents($item->getPathname());
        if ($contents === false) {
            $issues[] = [
                'file' => $item->getPathname(),
                'issue' => 'Unable to read file',
                'hint' => 'Verify file permissions and encoding.',
            ];
            continue;
        }

        $metadata = ssot_extract_metadata($contents);

        if ($metadata['status'] === '') {
            $issues[] = [
                'file' => $item->getPathname(),
                'issue' => 'Missing `_Status:` metadata line',
                'hint' => 'Add `_Status: draft|adopted|deprecated_` near top of document.',
            ];
        }

        if ($metadata['last_updated'] === '') {
            $issues[] = [
                'file' => $item->getPathname(),
                'issue' => 'Missing `_Last updated (UTC):` metadata line',
                'hint' => 'Add `_Last updated (UTC): YYYY-MM-DD_` near top of document.',
            ];
        }
    }

    return $issues;
}

/**
 * @return array<int,array{file:string,target:string,issue:string,hint:string}>
 */
function ssot_check_markdown_links(string $ssotRoot): array
{
    $issues = [];

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($ssotRoot, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $item) {
        if (!$item instanceof SplFileInfo || $item->getExtension() !== 'md') {
            continue;
        }

        $filePath = $item->getPathname();
        $contents = file_get_contents($filePath);

        if ($contents === false) {
            continue;
        }

        if (preg_match_all('/\[[^\]]+\]\(([^)]+)\)/', $contents, $matches) < 1) {
            continue;
        }

        foreach ($matches[1] as $rawTarget) {
            $target = trim($rawTarget);
            if ($target === '' || str_starts_with($target, 'http://') || str_starts_with($target, 'https://') || str_starts_with($target, '#')) {
                continue;
            }

            $targetWithoutAnchor = explode('#', $target)[0];
            if ($targetWithoutAnchor === '') {
                continue;
            }

            $candidatePath = str_starts_with($targetWithoutAnchor, '/')
                ? ssot_repo_root() . $targetWithoutAnchor
                : dirname($filePath) . '/' . $targetWithoutAnchor;

            if (!file_exists($candidatePath)) {
                $issues[] = [
                    'file' => $filePath,
                    'target' => $target,
                    'issue' => 'Broken markdown reference',
                    'hint' => 'Update path or create missing target file.',
                ];
            }
        }
    }

    return $issues;
}

/**
 * @return array<int,array{route:string,method:string}>
 */
function ssot_parse_route_inventory(string $inventoryFile): array
{
    $contents = file_get_contents($inventoryFile);
    if ($contents === false) {
        return [];
    }

    $routes = [];
    $lines = preg_split('/\R/', $contents) ?: [];

    foreach ($lines as $line) {
        if (!str_starts_with(trim($line), '| `/')) {
            continue;
        }

        $columns = array_map('trim', explode('|', trim($line, '|')));
        if (count($columns) < 2) {
            continue;
        }

        $route = trim($columns[0], "` \t");
        $method = strtoupper(trim($columns[1]));

        if ($route === '' || $method === '' || $method === 'METHOD') {
            continue;
        }

        $routes[] = [
            'route' => $route,
            'method' => $method,
        ];
    }

    return $routes;
}

/**
 * @return array<int,array{route:string,method:string}>
 */
function ssot_parse_openapi_paths(string $openApiFile): array
{
    $contents = file_get_contents($openApiFile);
    if ($contents === false) {
        return [];
    }

    $routes = [];
    $currentPath = null;
    $lines = preg_split('/\R/', $contents) ?: [];

    foreach ($lines as $line) {
        if (preg_match('/^\s{2}(\/[^:]*):\s*$/', $line, $pathMatch) === 1) {
            $currentPath = trim($pathMatch[1]);
            continue;
        }

        if ($currentPath !== null && preg_match('/^\s{4}(get|post|put|patch|delete|options|head):\s*$/i', $line, $methodMatch) === 1) {
            $routes[] = [
                'route' => $currentPath,
                'method' => strtoupper($methodMatch[1]),
            ];
        }
    }

    return $routes;
}

/**
 * @param array<int,array{route:string,method:string}> $inventoryRoutes
 * @param array<int,array{route:string,method:string}> $openapiRoutes
 * @return array{missing_in_openapi: array<int,array{route:string,method:string}>, missing_in_inventory: array<int,array{route:string,method:string}>}
 */
function ssot_diff_routes(array $inventoryRoutes, array $openapiRoutes): array
{
    $inventoryKeys = [];
    foreach ($inventoryRoutes as $route) {
        $inventoryKeys[$route['method'] . ' ' . $route['route']] = $route;
    }

    $openapiKeys = [];
    foreach ($openapiRoutes as $route) {
        $openapiKeys[$route['method'] . ' ' . $route['route']] = $route;
    }

    $missingInOpenApi = [];
    foreach ($inventoryKeys as $key => $route) {
        if (!isset($openapiKeys[$key])) {
            $missingInOpenApi[] = $route;
        }
    }

    $missingInInventory = [];
    foreach ($openapiKeys as $key => $route) {
        if (!isset($inventoryKeys[$key])) {
            $missingInInventory[] = $route;
        }
    }

    return [
        'missing_in_openapi' => array_values($missingInOpenApi),
        'missing_in_inventory' => array_values($missingInInventory),
    ];
}

function ssot_write_json_report(string $fileName, array $payload): void
{
    $dir = ssot_code_root_dir() . '/build/ssot';
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    file_put_contents(
        $dir . '/' . $fileName,
        json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL
    );
}
