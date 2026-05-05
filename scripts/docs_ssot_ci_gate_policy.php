<?php

declare(strict_types=1);

$workflowPath = __DIR__ . '/../.github/workflows/ssot_phase_gate.yml';
if (!is_file($workflowPath)) {
    fwrite(STDERR, "[CI-GATE-POLICY] workflow missing: {$workflowPath}" . PHP_EOL);
    exit(1);
}

$workflow = (string) file_get_contents($workflowPath);
$requiredRuns = [
    'composer validate --strict',
    'composer docs:ssot:lint',
    'composer docs:ssot:sync-check',
    'composer docs:ssot:report',
    'composer docs:ssot:trace-convention-check',
    'composer docs:ssot:command-registry-audit',
    'composer phase2:acceptance-bundle',
    'composer phase3:final-acceptance-bundle',
];

$positions = [];
$errors = [];
foreach ($requiredRuns as $command) {
    $position = strpos($workflow, $command);
    if ($position === false) {
        $errors[] = "missing required CI gate command: {$command}";
        continue;
    }
    $positions[$command] = $position;
}

if ($errors === []) {
    $orderChecks = [
        ['composer docs:ssot:lint', 'composer phase2:acceptance-bundle'],
        ['composer docs:ssot:sync-check', 'composer phase2:acceptance-bundle'],
        ['composer docs:ssot:report', 'composer phase2:acceptance-bundle'],
        ['composer phase2:acceptance-bundle', 'composer phase3:final-acceptance-bundle'],
    ];

    foreach ($orderChecks as [$first, $second]) {
        if (($positions[$first] ?? PHP_INT_MAX) > ($positions[$second] ?? -1)) {
            $errors[] = "ordering violation: {$first} must appear before {$second}";
        }
    }
}

if (!str_contains($workflow, "scripts/docs_ssot_*.php") || !str_contains($workflow, "scripts/test_contract_*.php")) {
    $errors[] = 'workflow path filters must include scripts/docs_ssot_*.php and scripts/test_contract_*.php';
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, '[CI-GATE-POLICY] FAIL: ' . $error . PHP_EOL);
    }
    exit(1);
}

echo '[CI-GATE-POLICY] PASS: workflow includes required gate commands, ordering, and path filters.' . PHP_EOL;
