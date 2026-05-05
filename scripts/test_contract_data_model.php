<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/Persistence/CoreRelationshipMap.php';

use Cre8\Persistence\CoreRelationshipMap;

$docPath = dirname(__DIR__) . '/docs/40_data_security_and_crypto/ERD.md';
$doc = file_get_contents($docPath);
if (!is_string($doc)) {
    fwrite(STDERR, "Unable to read ERD doc\n");
    exit(1);
}

$rows = CoreRelationshipMap::erdRows();
foreach ($rows as $row) {
    $needle = sprintf('| %s | %s | %s | %s | %s | %s |', $row['parent'], $row['child'], $row['cardinality'], $row['fk_column'], $row['on_delete'], $row['on_update']);
    if (!str_contains($doc, $needle)) {
        fwrite(STDERR, "Missing ERD relationship row in doc: {$needle}\n");
        exit(1);
    }
}

echo 'test:contract:data-model PASS (rows=' . count($rows) . ')' . PHP_EOL;
