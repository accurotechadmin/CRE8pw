<?php

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$routeInventoryPath = $repoRoot . '/docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md';
$openApiPath = $repoRoot . '/docs/31_machine_contracts/openapi/cre8.v1.yaml';
$proseParityPath = $repoRoot . '/docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md';
$errorCatalogPath = $repoRoot . '/docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md';

$routeInventory = file_get_contents($routeInventoryPath);
$openApi = file_get_contents($openApiPath);
$proseParity = file_get_contents($proseParityPath);
$traceabilityMatrixPath = $repoRoot . '/docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md';
$adrIndexPath = $repoRoot . '/docs/80_traceability_decisions_and_program/ADR_INDEX.md';
$decisionsLogPath = $repoRoot . '/docs/80_traceability_decisions_and_program/DECISIONS_LOG.md';
$phase2ProgressBoardPath = $repoRoot . '/reports/session_handoffs/PHASE2_PROGRESS_BOARD.md';
$traceabilityMatrix = file_get_contents($traceabilityMatrixPath);
$adrIndex = file_get_contents($adrIndexPath);
$decisionsLog = file_get_contents($decisionsLogPath);
$phase2ProgressBoard = file_get_contents($phase2ProgressBoardPath);
$errorCatalog = file_get_contents($errorCatalogPath);
if ($routeInventory === false || $openApi === false || $proseParity === false || $traceabilityMatrix === false || $adrIndex === false || $decisionsLog === false || $phase2ProgressBoard === false || $errorCatalog === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] unable to read route inventory, OpenAPI, prose parity file, traceability matrix, ADR index, decisions log, Phase 2 progress board, or error catalog" . PHP_EOL);
    exit(1);
}

$inventoryPairs = [];
$inventoryRouteIds = [];
$inventoryFamilies = [];
foreach (explode("\n", $routeInventory) as $line) {
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 3) {
        continue;
    }
    $routeId = strtoupper($cols[0]);
    $method = strtoupper($cols[1]);
    $path = $cols[2];
    $inventoryPairs[$method . ' ' . $path] = true;
    $inventoryRouteIds[$routeId] = $method . ' ' . $path;
    if (count($cols) >= 8) {
        $requiredPermission = strtolower(trim($cols[4]));
        $family = 'uncategorized';
        if (str_starts_with($requiredPermission, 'authz.')) {
            $family = 'auth_decision';
        } elseif (str_starts_with($requiredPermission, 'key.lifecycle.')) {
            $family = 'key_lifecycle';
        } elseif (str_starts_with($requiredPermission, 'feed.')) {
            $family = 'feed_audience';
        } elseif (str_starts_with($requiredPermission, 'system.')) {
            $family = 'system_health';
        }
        $inventoryFamilies[$family] = true;
    }
}

$openApiPairs = [];
$lines = explode("\n", $openApi);
$currentPath = null;
foreach ($lines as $line) {
    if (preg_match('/^\s{2}(\/[^:]+):\s*$/', $line, $m) === 1) {
        $currentPath = trim($m[1]);
        continue;
    }
    if ($currentPath !== null && preg_match('/^\s{4}(get|post|put|patch|delete|options|head):\s*$/i', $line, $m) === 1) {
        $method = strtoupper($m[1]);
        $openApiPairs[$method . ' ' . $currentPath] = true;
    }
}

$errors = [];


$inventoryErrorCodesByRoute = [];
foreach (explode("\n", $routeInventory) as $line) {
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 8) {
        continue;
    }
    $routeId = strtoupper($cols[0]);
    $errorCodes = array_filter(array_map('trim', explode(',', $cols[7])), static fn(string $code): bool => $code !== '');
    $inventoryErrorCodesByRoute[$routeId] = [];
    foreach ($errorCodes as $code) {
        $inventoryErrorCodesByRoute[$routeId][strtoupper($code)] = true;
    }
}

$catalogCodes = [];
foreach (explode("\n", $errorCatalog) as $line) {
    if (!preg_match('/^\|\s*(AUTH|SYSTEM)_[A-Z0-9_]+\s*\|/', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 1) {
        continue;
    }
    $catalogCodes[strtoupper($cols[0])] = true;
}

$traceRequirementIds = [];
$traceHookIds = [];
foreach (explode("\n", $traceabilityMatrix) as $line) {
    if (!preg_match('/^\|\s*CRE8-[A-Z]+-REQ-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 4) {
        continue;
    }
    $traceRequirementIds[strtoupper($cols[0])] = true;
    $traceHookIds[strtoupper($cols[3])] = true;
}

foreach (array_keys($inventoryPairs) as $pair) {
    if (!isset($openApiPairs[$pair])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing in OpenAPI: {$pair}";
    }
}
foreach (array_keys($openApiPairs) as $pair) {
    if (!isset($inventoryPairs[$pair])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing in route inventory: {$pair}";
    }
}



$openApiResponseSchemas = [];
$currentPath = null;
$currentMethod = null;
$currentStatus = null;
$inAppJson = false;
$inSchema = false;
foreach ($lines as $line) {
    if (preg_match('/^\s{2}(\/[^:]+):\s*$/', $line, $m) === 1) {
        $currentPath = trim($m[1]);
        $currentMethod = null;
        $currentStatus = null;
        $inAppJson = false;
        $inSchema = false;
        continue;
    }
    if ($currentPath !== null && preg_match('/^\s{4}(get|post|put|patch|delete|options|head):\s*$/i', $line, $m) === 1) {
        $currentMethod = strtoupper($m[1]);
        $currentStatus = null;
        $inAppJson = false;
        $inSchema = false;
        continue;
    }
    if ($currentMethod !== null && preg_match("/^\s{8}'([0-9]{3})':\s*$/", $line, $m) === 1) {
        $currentStatus = $m[1];
        $inAppJson = false;
        $inSchema = false;
        continue;
    }
    if ($currentStatus !== null && preg_match('/^\s{12}application\/json:\s*$/', $line) === 1) {
        $inAppJson = true;
        $inSchema = false;
        continue;
    }
    if ($inAppJson && preg_match('/^\s{14}schema:\s*$/', $line) === 1) {
        $inSchema = true;
        continue;
    }
    if ($inSchema && preg_match('/^\s{16}/', $line) === 1 && str_contains(trim($line), '$ref:')) {
        $trimmed = trim($line);
        $ref = trim(substr($trimmed, strlen('$ref:')));
        $ref = trim($ref, "'\"");
        $pair = $currentMethod . ' ' . $currentPath;
        $openApiResponseSchemas[$pair][$currentStatus] = $ref;
        $inSchema = false;
        $inAppJson = false;
        continue;
    }
    if (trim($line) === '') {
        continue;
    }
}


$openApiResponseExamples = [];
$currentPath = null;
$currentMethod = null;
$currentStatus = null;
$inExamples = false;
foreach ($lines as $line) {
    if (preg_match('/^\s{2}(\/[^:]+):\s*$/', $line, $m) === 1) {
        $currentPath = trim($m[1]);
        $currentMethod = null;
        $currentStatus = null;
        $inExamples = false;
        continue;
    }
    if ($currentPath !== null && preg_match('/^\s{4}(get|post|put|patch|delete|options|head):\s*$/i', $line, $m) === 1) {
        $currentMethod = strtoupper($m[1]);
        $currentStatus = null;
        $inExamples = false;
        continue;
    }
    if ($currentMethod !== null && preg_match("/^\s{8}'([0-9]{3})':\s*$/", $line, $m) === 1) {
        $currentStatus = $m[1];
        $inExamples = false;
        continue;
    }
    if ($currentStatus !== null && preg_match('/^\s{14}examples:\s*$/', $line) === 1) {
        $inExamples = true;
        continue;
    }
    if ($inExamples && preg_match('/^\s{16}[A-Za-z0-9_-]+:\s*$/', $line) === 1) {
        continue;
    }
    if ($inExamples && preg_match('/^\s{18}\$ref:\s*(.+)\s*$/', $line, $m) === 1) {
        $ref = trim($m[1], " '\"");
        $pair = $currentMethod . ' ' . $currentPath;
        $openApiResponseExamples[$pair][$currentStatus][] = $ref;
        continue;
    }
}

$exampleCodeMap = [];
$currentExampleRef = null;
foreach ($lines as $line) {
    if (preg_match('/^\s{4}([A-Za-z0-9_-]+):\s*$/', $line, $m) === 1) {
        $currentExampleRef = '#/components/examples/' . $m[1];
        continue;
    }
    if ($currentExampleRef !== null && preg_match('/code:\s*([A-Z0-9_]+)/', $line, $m) === 1) {
        $exampleCodeMap[$currentExampleRef] = trim($m[1]);
        $currentExampleRef = null;
    }
}
// Validate prose parity table rows remain synchronized and contain Phase 2 depth metadata.
$proseRows = [];
$familyHighPriorityCounts = [];
$coveragePolicies = [];
foreach (explode("\n", $proseParity) as $line) {
    if (preg_match('/^\|\s*[a-z0-9_]+\s*\|\s*[0-9]+\s*\|\s*CRE8-[A-Z]+-REQ-[0-9]{4}\s*\|\s*HOOK-[A-Z0-9-]+\s*\|/i', trim($line)) === 1) {
        $coverageCols = array_map('trim', explode('|', trim($line, '|')));
        if (count($coverageCols) >= 8) {
            $family = $coverageCols[0];
            $minimum = (int) $coverageCols[1];
            $coverageRequirementId = strtoupper($coverageCols[2]);
            $coverageHookId = strtoupper($coverageCols[3]);
            $coverageOwner = trim($coverageCols[4]);
            $coverageDecisionRef = strtoupper(trim($coverageCols[5]));
            $coverageDueDate = trim($coverageCols[6]);
            $coveragePolicies[$family] = [
                'minimum_high_priority_routes' => $minimum,
                'requirement_id' => $coverageRequirementId,
                'hook_id' => $coverageHookId,
                'owner' => $coverageOwner,
                'decision_ref' => $coverageDecisionRef,
                'phase2_due_date_utc' => $coverageDueDate,
            ];

            if ($coverageDueDate !== 'n/a' && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $coverageDueDate) !== 1) {
                $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] coverage policy phase2_due_date_utc must be YYYY-MM-DD or n/a for family {$family}: {$coverageDueDate}";
            }
            if (!isset($traceRequirementIds[$coverageRequirementId])) {
                $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] coverage policy requirement_id not found in traceability matrix for family {$family}: {$coverageRequirementId}";
            }
            if (!isset($traceHookIds[$coverageHookId])) {
                $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] coverage policy hook_id not found in traceability matrix for family {$family}: {$coverageHookId}";
            }
        }
    }
    if (!preg_match('/^\|\s*CRE8-ROUTE-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 17) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] malformed prose parity row: {$line}";
        continue;
    }

    [$routeId, $inventoryMethod, $inventoryPath, $openApiMethod, $openApiPath, $parityStatus, $routeFamily, $depthPriority, $requirementId, $hookId, $depthStatus, $successSchemaRef, $errorSchemaRef, $successStatusCodes, $errorStatusCodes, $errorExampleRefs, $errorCodes] = $cols;
    $routeId = strtoupper($routeId);
    if (isset($proseRows[$routeId])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] duplicate prose parity route_id row: {$routeId}";
    }
    $pair = strtoupper($inventoryMethod) . ' ' . $inventoryPath;
    $openApiPair = strtoupper($openApiMethod) . ' ' . $openApiPath;
    $proseRows[$routeId] = true;

    if (!isset($inventoryRouteIds[$routeId])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] prose parity route_id not found in inventory: {$routeId}";
    } elseif ($inventoryRouteIds[$routeId] !== $pair) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] prose inventory tuple mismatch for {$routeId}";
    }
    if (!isset($openApiPairs[$openApiPair])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] prose OpenAPI tuple missing for {$routeId}: {$openApiPair}";
    }
    if ($parityStatus !== 'in_sync') {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] parity_status must be in_sync for {$routeId}";
    }
    if (!preg_match('/^CRE8-[A-Z]+-REQ-[0-9]{4}$/', $requirementId)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid primary_requirement_id for {$routeId}: {$requirementId}";
    } elseif (!isset($traceRequirementIds[strtoupper($requirementId)])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] primary_requirement_id not found in traceability matrix for {$routeId}: {$requirementId}";
    }
    if (!preg_match('/^HOOK-[A-Z0-9-]+$/', $hookId)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid primary_hook_id for {$routeId}: {$hookId}";
    } elseif (!isset($traceHookIds[strtoupper($hookId)])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] primary_hook_id not found in traceability matrix for {$routeId}: {$hookId}";
    }
    if ($routeFamily === '' || $depthPriority === '' || $depthStatus === '') {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing Phase 2 depth metadata for {$routeId}";
    }
    if (!in_array($depthStatus, ['baseline_complete', 'depth_in_progress', 'depth_complete'], true)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid parity_depth_status for {$routeId}: {$depthStatus}";
    }
    if ($depthPriority === 'high') {
        $familyHighPriorityCounts[$routeFamily] = ($familyHighPriorityCounts[$routeFamily] ?? 0) + 1;
    }

    if (!preg_match('/^#\/components\/schemas\/[A-Za-z0-9._-]+$/', $successSchemaRef)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid success_schema_ref for {$routeId}: {$successSchemaRef}";
    } elseif (strpos($openApi, $successSchemaRef) === false) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] success_schema_ref not found in OpenAPI for {$routeId}: {$successSchemaRef}";
    }
    if (!preg_match('/^#\/components\/schemas\/[A-Za-z0-9._-]+$/', $errorSchemaRef)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid error_schema_ref for {$routeId}: {$errorSchemaRef}";
    } elseif (strpos($openApi, $errorSchemaRef) === false) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] error_schema_ref not found in OpenAPI for {$routeId}: {$errorSchemaRef}";
    }

    $successStatuses = array_filter(array_map('trim', explode(',', $successStatusCodes)), static fn(string $code): bool => $code !== '');
    $errorStatuses = array_filter(array_map('trim', explode(',', $errorStatusCodes)), static fn(string $code): bool => $code !== '');
    if ($successStatuses === [] || $errorStatuses === []) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing status-code metadata for {$routeId}";
    }

    foreach ($successStatuses as $status) {
        if (!preg_match('/^[0-9]{3}$/', $status)) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid success status code for {$routeId}: {$status}";
            continue;
        }
        if (!isset($openApiResponseSchemas[$openApiPair][$status])) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] success status code not found in OpenAPI for {$routeId}: {$status}";
            continue;
        }
        if ($openApiResponseSchemas[$openApiPair][$status] !== $successSchemaRef) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] success schema mismatch for {$routeId} status {$status}";
        }
    }

    $declaredExampleRefs = array_filter(array_map('trim', explode(',', $errorExampleRefs)), static fn(string $ref): bool => $ref !== '');
    $declaredErrorCodes = array_filter(array_map('trim', explode(',', $errorCodes)), static fn(string $code): bool => $code !== '');
    if ($declaredExampleRefs === [] || $declaredErrorCodes === []) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing error example/code metadata for {$routeId}";
    }
    $openApiExampleRefs = [];
    foreach ($errorStatuses as $status) {
        foreach ($openApiResponseExamples[$openApiPair][$status] ?? [] as $ref) {
            $openApiExampleRefs[$ref] = true;
        }
    }
    foreach ($declaredExampleRefs as $ref) {
        if (!isset($openApiExampleRefs[$ref])) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] error example ref not found in OpenAPI responses for {$routeId}: {$ref}";
        }
        if (!isset($exampleCodeMap[$ref])) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] error example ref missing code mapping for {$routeId}: {$ref}";
        }
    }
    foreach (array_keys($openApiExampleRefs) as $ref) {
        if (!in_array($ref, $declaredExampleRefs, true)) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] OpenAPI error example ref missing from prose parity row for {$routeId}: {$ref}";
        }
    }
    $exampleCodes = [];
    foreach ($declaredExampleRefs as $ref) {
        if (isset($exampleCodeMap[$ref])) {
            $exampleCodes[$exampleCodeMap[$ref]] = true;
        }
    }
    foreach ($declaredErrorCodes as $code) {
        $code = strtoupper($code);
        if (!preg_match('/^[A-Z0-9_]+$/', $code)) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid error code format for {$routeId}: {$code}";
            continue;
        }
        if (!isset($exampleCodes[$code])) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] declared error code missing from declared examples for {$routeId}: {$code}";
        }

        if (!isset($catalogCodes[$code])) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] declared error code not found in ERROR_CODE_CATALOG for {$routeId}: {$code}";
        }
        if (!isset($inventoryErrorCodesByRoute[$routeId][$code])) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] declared error code not listed in route inventory error_code_set for {$routeId}: {$code}";
        }
    }
    foreach (array_keys($exampleCodes) as $code) {
        $code = strtoupper($code);
        if (!in_array($code, array_map('strtoupper', $declaredErrorCodes), true)) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] OpenAPI-derived error code missing from prose parity row for {$routeId}: {$code}";
        }
    }
    foreach (array_keys($inventoryErrorCodesByRoute[$routeId] ?? []) as $inventoryCode) {
        if (!in_array($inventoryCode, array_map('strtoupper', $declaredErrorCodes), true) && $inventoryCode !== 'AUTH_CREDENTIAL_INVALID' && $inventoryCode !== 'AUTH_PERMISSION_DENIED') {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] inventory error code missing from parity row (excluding baseline global auth denials) for {$routeId}: {$inventoryCode}";
        }
    }
    foreach ($errorStatuses as $status) {
        if (!preg_match('/^[0-9]{3}$/', $status)) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid error status code for {$routeId}: {$status}";
            continue;
        }
        if (!isset($openApiResponseSchemas[$openApiPair][$status])) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] error status code not found in OpenAPI for {$routeId}: {$status}";
            continue;
        }
        if ($openApiResponseSchemas[$openApiPair][$status] !== $errorSchemaRef) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] error schema mismatch for {$routeId} status {$status}";
        }
    }

}

if ($coveragePolicies === []) {
    $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing Route Family Coverage Policy table rows in prose parity table";
}
foreach ($familyHighPriorityCounts as $family => $_count) {
    if (!isset($coveragePolicies[$family])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing coverage policy row for route_family: {$family}";
    }
}

foreach (array_keys($inventoryFamilies) as $family) {
    if (!isset($coveragePolicies[$family])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing coverage policy row for inventory-derived family: {$family}";
    }
}

$adrIds = [];
foreach (explode("
", $adrIndex) as $line) {
    if (preg_match('/^\|\s*ADR-[0-9]{3}\s*\|/i', trim($line)) !== 1) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if ($cols === []) {
        continue;
    }
    $adrIds[strtoupper($cols[0])] = true;
}


$approvedOwners = [];
foreach (explode("\n", $traceabilityMatrix) as $line) {
    if (!preg_match('/^\|\s*CRE8-[A-Z]+-REQ-[0-9]{4}\s*\|/i', trim($line))) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 6) {
        continue;
    }
    if ($cols[5] !== '') {
        $approvedOwners[strtoupper($cols[5])] = true;
    }
}

$decisionEventIds = [];
foreach (explode("
", $decisionsLog) as $line) {
    if (preg_match('/^\|\s*DLOG-[0-9]{8}-[0-9]{3}\s*\|/i', trim($line)) !== 1) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if ($cols === []) {
        continue;
    }
    $decisionEventIds[strtoupper($cols[0])] = true;
}
$deferredBreadthRows = [];
foreach (explode("\n", $phase2ProgressBoard) as $line) {
    if (preg_match('/^\|\s*P2-DB-[0-9]{3}\s*\|/i', trim($line)) !== 1) {
        continue;
    }
    $cols = array_map('trim', explode('|', trim($line, '|')));
    if (count($cols) < 8) {
        continue;
    }
    $deferredBreadthRows[] = [
        'item_id' => strtoupper($cols[0]),
        'owner' => $cols[3],
        'hooks' => strtoupper($cols[5]),
        'decision_ref' => strtoupper($cols[7]),
    ];
}

foreach ($coveragePolicies as $family => $policy) {
    if (!preg_match('/^[a-z0-9_]+$/', $family)) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid route_family format in coverage policy: {$family}";
    }
    if ($policy['minimum_high_priority_routes'] < 0) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] minimum_high_priority_routes cannot be negative for family {$family}";
    }
    if ($policy['owner'] === '') {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing owner in coverage policy for family {$family}";
    } elseif (!isset($approvedOwners[strtoupper($policy['owner'])])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] coverage policy owner not found in ownership matrix for family {$family}: {$policy['owner']}";
    }
    if (!preg_match('/^(ADR-[0-9]{3}|DLOG-[0-9]{8}-[0-9]{3})$/', $policy['decision_ref'])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] invalid decision_ref in coverage policy for family {$family}: {$policy['decision_ref']}";
        continue;
    }
    if (str_starts_with($policy['decision_ref'], 'ADR-') && !isset($adrIds[$policy['decision_ref']])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] coverage policy decision_ref ADR not found in ADR_INDEX for family {$family}: {$policy['decision_ref']}";
    }
    if (str_starts_with($policy['decision_ref'], 'DLOG-') && !isset($decisionEventIds[$policy['decision_ref']])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] coverage policy decision_ref event not found in DECISIONS_LOG for family {$family}: {$policy['decision_ref']}";
    }
    if ($policy['decision_ref'] === 'ADR-003') {
        $hasLinkedDeferredRow = false;
        foreach ($deferredBreadthRows as $deferredRow) {
            if ($deferredRow['decision_ref'] !== 'ADR-003') {
                continue;
            }
            if (strtoupper($deferredRow['owner']) !== strtoupper($policy['owner'])) {
                continue;
            }
            if (!str_contains($deferredRow['hooks'], strtoupper($policy['hook_id']))) {
                continue;
            }
            $hasLinkedDeferredRow = true;
            break;
        }
        if (!$hasLinkedDeferredRow) {
            $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] ADR-003 coverage policy row lacks matching deferred-breadth linkage (owner + hook) in PHASE2_PROGRESS_BOARD for family {$family}";
        }
    }
}

foreach ($coveragePolicies as $family => $policy) {
    $actual = $familyHighPriorityCounts[$family] ?? 0;
    $minimum = $policy['minimum_high_priority_routes'];
    if ($actual < $minimum) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] high-priority route coverage below minimum for family {$family}: actual={$actual}, minimum={$minimum}";
    }
}

foreach (array_keys($inventoryRouteIds) as $routeId) {
    if (!isset($proseRows[$routeId])) {
        $errors[] = "[HOOK-CONTRACT-ROUTE-INVENTORY-PARITY] missing route in prose parity table: {$routeId}";
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'docs:ssot:route-parity PASS (pairs=' . count($inventoryPairs) . ', prose_rows=' . count($proseRows) . ')' . PHP_EOL;
