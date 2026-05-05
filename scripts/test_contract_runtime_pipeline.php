<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/Policy/PolicyDecisionPointInterface.php';
require dirname(__DIR__) . '/src/Application/RuntimeTerms.php';
require dirname(__DIR__) . '/src/Application/PipelineRuntime.php';

use Cre8\Application\PipelineRuntime;
use Cre8\Application\RuntimeTerms;
use Cre8\Policy\PolicyDecisionPointInterface;

final class AllowPdp implements PolicyDecisionPointInterface
{
    public function decide(array $evaluationContext): array
    {
        return ['outcome' => RuntimeTerms::allow()];
    }
}

final class DenyPdp implements PolicyDecisionPointInterface
{
    public function decide(array $evaluationContext): array
    {
        return ['outcome' => RuntimeTerms::deny(), 'reason_code' => 'AUTH_DENY_POLICY'];
    }
}

$proof = [
    'request_id' => 'req-contract-001',
    'public_key_id' => 'pk_1',
    'timestamp' => '2026-05-05T08:00:00Z',
    'nonce' => 'n1',
    'signature' => 'sig',
];

$denyResponse = (new PipelineRuntime(new DenyPdp()))->handleProtected($proof);
if (($denyResponse['error']['code'] ?? null) !== 'AUTH_DENY_POLICY') {
    fwrite(STDERR, '[HOOK-CONTRACT-AUTH-PIPELINE-DENY] missing deny mapping from PDP reason code' . PHP_EOL);
    exit(1);
}
if (($denyResponse['meta']['request_id'] ?? null) !== 'req-contract-001') {
    fwrite(STDERR, '[HOOK-CONTRACT-REQUEST-ID-CONTINUITY] deny path request_id continuity failed' . PHP_EOL);
    exit(1);
}

$allowResponse = (new PipelineRuntime(new AllowPdp()))->handleProtected($proof);
if (!isset($allowResponse['data'], $allowResponse['meta']['request_id'])) {
    fwrite(STDERR, '[HOOK-CONTRACT-ENVELOPE-SHAPE] success envelope {data, meta} missing' . PHP_EOL);
    exit(1);
}

$invalidAuthn = (new PipelineRuntime(new AllowPdp()))->handleProtected(['request_id' => 'req-contract-002']);
if (($invalidAuthn['error']['code'] ?? null) !== 'AUTHN_PROOF_INVALID') {
    fwrite(STDERR, '[HOOK-CONTRACT-AUTHN-PROOF-VERIFY] authentication proof validation did not fail deterministically' . PHP_EOL);
    exit(1);
}

echo 'test:contract:runtime-pipeline PASS' . PHP_EOL;
