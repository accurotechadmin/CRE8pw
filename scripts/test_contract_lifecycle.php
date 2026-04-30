<?php
declare(strict_types=1);

$root = dirname(__DIR__);
$openapiPath = $root . '/docs/31_machine_contracts/openapi/cre8.v1.yaml';
$parityPath = $root . '/docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md';

$openapi = is_file($openapiPath) ? file_get_contents($openapiPath) : false;
$parity = is_file($parityPath) ? file_get_contents($parityPath) : false;

if (!is_string($openapi) || !is_string($parity)) {
    fwrite(STDERR, "Required lifecycle contract artifacts missing.\n");
    exit(1);
}

$requiredOpenApiSnippets = [
    'action: "feed.items.read"' => 'feed action fixture',
    '/v1/keys/{key_id}/lifecycle/suspend' => 'lifecycle suspend path',
    '/v1/keys/{key_id}/lifecycle/revoke' => 'lifecycle revoke path',
    'AUTH_LIFECYCLE_BLOCKED' => 'canonical lifecycle deny code',
    'ErrorLifecycleBlocked' => 'key lifecycle deny example',
    'ErrorInteractionLifecycleBlocked' => 'interaction lifecycle deny example',
    'action: "comment.create"' => 'interaction action fixture',
];

foreach ($requiredOpenApiSnippets as $snippet => $label) {
    if (!str_contains($openapi, $snippet)) {
        fwrite(STDERR, "Missing {$label} in OpenAPI: {$snippet}\n");
        exit(1);
    }
}

$requiredParityRows = [
    'CRE8-ROUTE-0003 | POST | /v1/keys/{key_id}/lifecycle/suspend',
    'CRE8-ROUTE-0005 | POST | /v1/keys/{key_id}/lifecycle/revoke',
    'HOOK-SEC-LIFECYCLE-PROPAGATION',
    'depth_in_progress',
];

foreach ($requiredParityRows as $snippet) {
    if (!str_contains($parity, $snippet)) {
        fwrite(STDERR, "Missing lifecycle parity linkage snippet: {$snippet}\n");
        exit(1);
    }
}


$distinctLifecycleExamples = [
    'ErrorFeedLifecycleBlocked' => 'req-feed-',
    'ErrorInteractionLifecycleBlocked' => 'req-interact-',
];

foreach ($distinctLifecycleExamples as $exampleName => $requestPrefix) {
    $pattern = '/\n\s{4}' . preg_quote($exampleName, '/') . ':\n\s{6}value:\n\s{8}error:\s\{[^\n]*request_id:\s"' . preg_quote($requestPrefix, '/') . '[^"\n]*"[^\n]*\}/m';
    if (preg_match($pattern, $openapi) !== 1) {
        fwrite(STDERR, "Lifecycle deny example {$exampleName} missing expected request_id prefix {$requestPrefix}\n");
        exit(1);
    }
}

echo 'test:contract:lifecycle PASS (routes=2, deny_examples=2, action_fixtures=feed.items.read+comment.create, lifecycle_example_prefixes=validated, parity_hook=HOOK-SEC-LIFECYCLE-PROPAGATION)' . PHP_EOL;
