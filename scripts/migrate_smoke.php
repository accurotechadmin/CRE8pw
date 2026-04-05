<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$migration = $root . '/db/migrations/0001_init.sql';
if (!is_file($migration)) {
    fwrite(STDERR, "migration_missing\n");
    exit(1);
}

$pdo = new PDO('sqlite::memory:');
$sql = (string) file_get_contents($migration);
$sql = (string) preg_replace('/^--.*$/m', '', $sql);
$normalized = str_replace(['TIMESTAMPTZ', 'JSONB', 'NOW()'], ['TEXT', 'TEXT', "CURRENT_TIMESTAMP"], $sql);
$normalized = preg_replace('/ON UPDATE CASCADE/', '', (string) $normalized);
$normalized = preg_replace('/\bUUID\b/', 'TEXT', (string) $normalized);

$statements = array_filter(array_map('trim', explode(';', (string) $normalized)));
foreach ($statements as $statement) {
    if (str_starts_with($statement, '--')) {
        continue;
    }

    if (str_starts_with(strtoupper($statement), 'ALTER TABLE')) {
        continue;
    }

    if ($statement !== '') {
        $pdo->exec($statement);
    }
}

$requiredTables = ['principals', 'principal_emails', 'credentials', 'token_families', 'delegation_envelopes', 'posts', 'comments', 'audit_events'];
foreach ($requiredTables as $table) {
    $q = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='" . $table . "'");
    if ($q === false || $q->fetchColumn() === false) {
        fwrite(STDERR, "missing_table:$table\n");
        exit(2);
    }
}

echo "migration_smoke_ok\n";
