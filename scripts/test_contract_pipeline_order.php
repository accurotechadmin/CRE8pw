<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/Application/PipelineStage.php';
require dirname(__DIR__) . '/src/Application/PipelineDefinition.php';

use Cre8\Application\PipelineDefinition;

$actual = array_map(static fn ($stage) => $stage->value, PipelineDefinition::orderedStages());
$expected = [
    'transport_security_headers',
    'request_correlation',
    'input_parsing',
    'authentication_proof_verification',
    'authorization_decision_gate',
    'handler_execution',
    'envelope_rendering',
    'structured_error_mapping',
];

if ($actual !== $expected) {
    fwrite(STDERR, '[HOOK-CONTRACT-AUTH-PIPELINE-ORDER] middleware order mismatch' . PHP_EOL);
    exit(1);
}

echo 'test:contract:pipeline-order PASS (stages=' . count($actual) . ')' . PHP_EOL;
