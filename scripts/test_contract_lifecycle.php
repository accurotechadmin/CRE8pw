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
    'ErrorDescendantLifecycleBlocked' => 'descendant lifecycle deny example',
    'ErrorDescendantLifecycleBlockedSecondary' => 'secondary descendant lifecycle deny example',
    'ErrorDescendantLifecycleBlockedTertiary' => 'tertiary descendant lifecycle deny example',
    'AuthDecisionRequestDescendantPropagation' => 'descendant propagation action fixture',
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
    'ErrorDescendantLifecycleBlocked' => 'req-desc-life-',
];

$descendantRequestIds = [];
if (preg_match_all('/request_id:\s"(req-desc-life-[0-9]{3})"/', $openapi, $descendantIdMatches) === false) {
    fwrite(STDERR, "Failed to parse descendant lifecycle request IDs for propagation breadth checks\n");
    exit(1);
}
$descendantRequestIds = array_values(array_unique($descendantIdMatches[1] ?? []));
if (count($descendantRequestIds) < 2) {
    fwrite(STDERR, "Expected at least two distinct req-desc-life-* fixtures for multi-actor propagation depth\n");
    exit(1);
}
if (!in_array('req-desc-life-003', $descendantRequestIds, true)) {
    fwrite(STDERR, "Expected tertiary req-desc-life-003 fixture for revoke/suspend timeline matrix depth\n");
    exit(1);
}

foreach ($distinctLifecycleExamples as $exampleName => $requestPrefix) {
    $pattern = '/\n\s{4}' . preg_quote($exampleName, '/') . ':\n\s{6}value:\n\s{8}error:\s\{[^\n]*request_id:\s"' . preg_quote($requestPrefix, '/') . '[^"\n]*"[^\n]*\}/m';
    if (preg_match($pattern, $openapi) !== 1) {
        fwrite(STDERR, "Lifecycle deny example {$exampleName} missing expected request_id prefix {$requestPrefix}\n");
        exit(1);
    }
}

$revokeEffectiveUtcPattern = '/LifecycleRevokeAccepted:\n\s{6}value:\n\s{8}data:\s\{[^\n]*effective_utc:\s"([^"]+)"/m';
$descendantBlockedUtcPattern = '/ErrorDescendantLifecycleBlocked:\n\s{6}value:\n\s{8}error:\s\{[^\n]*timestamp_utc:\s"([^"]+)"/m';
$suspendEffectiveUtcPattern = '/LifecycleSuspendAccepted:\n\s{6}value:\n\s{8}data:\s\{[^\n]*effective_utc:\s"([^"]+)"/m';
$descendantSecondaryUtcPattern = '/ErrorDescendantLifecycleBlockedSecondary:\n\s{6}value:\n\s{8}error:\s\{[^\n]*timestamp_utc:\s"([^"]+)"/m';
$descendantTertiaryUtcPattern = '/ErrorDescendantLifecycleBlockedTertiary:\n\s{6}value:\n\s{8}error:\s\{[^\n]*timestamp_utc:\s"([^"]+)"/m';

if (preg_match($revokeEffectiveUtcPattern, $openapi, $revokeMatch) !== 1) {
    fwrite(STDERR, "Lifecycle revoke fixture missing effective_utc for propagation chronology checks\n");
    exit(1);
}
if (preg_match($descendantBlockedUtcPattern, $openapi, $descendantMatch) !== 1) {
    fwrite(STDERR, "Descendant lifecycle deny fixture missing timestamp_utc for propagation chronology checks\n");
    exit(1);
}
if (preg_match($suspendEffectiveUtcPattern, $openapi, $suspendMatch) !== 1) {
    fwrite(STDERR, "Lifecycle suspend fixture missing effective_utc for propagation chronology checks\n");
    exit(1);
}
if (preg_match($descendantSecondaryUtcPattern, $openapi, $descendantSecondaryMatch) !== 1) {
    fwrite(STDERR, "Secondary descendant lifecycle deny fixture missing timestamp_utc for propagation chronology checks\n");
    exit(1);
}
if (preg_match($descendantTertiaryUtcPattern, $openapi, $descendantTertiaryMatch) !== 1) {
    fwrite(STDERR, "Tertiary descendant lifecycle deny fixture missing timestamp_utc for propagation chronology checks\n");
    exit(1);
}

$revokeTs = strtotime($revokeMatch[1]);
$descendantTs = strtotime($descendantMatch[1]);
$suspendTs = strtotime($suspendMatch[1]);
$descendantSecondaryTs = strtotime($descendantSecondaryMatch[1]);
$descendantTertiaryTs = strtotime($descendantTertiaryMatch[1]);
if ($revokeTs === false || $descendantTs === false || $suspendTs === false || $descendantSecondaryTs === false || $descendantTertiaryTs === false) {
    fwrite(STDERR, "Lifecycle chronology timestamps are not parseable ISO-8601 values\n");
    exit(1);
}
if ($descendantTs < $revokeTs) {
    fwrite(STDERR, "Descendant lifecycle deny timestamp precedes revoke effective_utc (chronology drift)\n");
    exit(1);
}
if ($descendantSecondaryTs < $suspendTs) {
    fwrite(STDERR, "Secondary descendant lifecycle deny timestamp precedes suspend effective_utc (chronology drift)\n");
    exit(1);
}
if ($descendantTertiaryTs < $descendantSecondaryTs) {
    fwrite(STDERR, "Tertiary descendant lifecycle deny timestamp precedes secondary descendant deny timestamp (timeline matrix drift)\n");
    exit(1);
}

echo 'test:contract:lifecycle PASS (routes=2, deny_examples=4, action_fixtures=feed.items.read+comment.create, lifecycle_example_prefixes=validated, descendant_chronology=validated, descendant_multi_actor=validated, revoke_suspend_timeline_matrix=validated, parity_hook=HOOK-SEC-LIFECYCLE-PROPAGATION)' . PHP_EOL;
