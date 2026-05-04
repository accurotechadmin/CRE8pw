<?php
$schemas = glob('docs/31_machine_contracts/schemas/*.schema.json');
if (!$schemas) {
    fwrite(STDERR, "[HOOK-CONTRACT-SCHEMA-COVERAGE] FAIL: no schema files found.\n");
    exit(1);
}

$violations = [];
$envelopeClosed = 0;
$dataClosed = 0;
$objectNodesChecked = 0;

$walk = static function (array $node, string $path, string $schemaFile) use (&$walk, &$violations, &$envelopeClosed, &$dataClosed, &$objectNodesChecked): void {
    $isObjectType = (($node['type'] ?? null) === 'object');
    $hasClosure = array_key_exists('additionalProperties', $node) || array_key_exists('unevaluatedProperties', $node);
    $isCompositionOnly = isset($node['allOf']) || isset($node['anyOf']) || isset($node['oneOf']) || isset($node['$ref']);

    if ($isObjectType) {
        $objectNodesChecked++;
        if (str_ends_with($path, '/properties/data')) {
            if (($node['additionalProperties'] ?? null) === false || ($node['unevaluatedProperties'] ?? null) === false) {
                $dataClosed++;
            } else {
                $violations[] = "{$schemaFile}:{$path} data object MUST declare additionalProperties:false or unevaluatedProperties:false";
            }
        } elseif (!$hasClosure && !$isCompositionOnly) {
            $violations[] = "{$schemaFile}:{$path} object schema missing explicit closure";
        } elseif ($hasClosure && ($node['additionalProperties'] ?? null) === false) {
            $envelopeClosed++;
        }
    }

    foreach (['allOf', 'anyOf', 'oneOf'] as $k) {
        if (isset($node[$k]) && is_array($node[$k])) {
            foreach ($node[$k] as $idx => $sub) {
                if (is_array($sub)) {
                    $walk($sub, "{$path}/{$k}/{$idx}", $schemaFile);
                }
            }
        }
    }
    if (isset($node['properties']) && is_array($node['properties'])) {
        foreach ($node['properties'] as $name => $sub) {
            if (is_array($sub)) {
                $walk($sub, "{$path}/properties/{$name}", $schemaFile);
            }
        }
    }
    if (isset($node['items']) && is_array($node['items'])) {
        $walk($node['items'], "{$path}/items", $schemaFile);
    }
};

foreach ($schemas as $schemaPath) {
    $decoded = json_decode(file_get_contents($schemaPath), true);
    if (!is_array($decoded)) {
        $violations[] = "{$schemaPath} invalid JSON schema payload";
        continue;
    }
    $walk($decoded, '#', $schemaPath);
}

if ($violations) {
    fwrite(STDERR, "[HOOK-CONTRACT-SCHEMA-COVERAGE] FAIL:\n - " . implode("\n - ", $violations) . "\n");
    exit(1);
}

echo "[HOOK-CONTRACT-SCHEMA-COVERAGE] PASS: schemas=" . count($schemas) . ", object_nodes_checked={$objectNodesChecked}, envelope_closures={$envelopeClosed}, data_closures={$dataClosed}.\n";
