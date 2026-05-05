<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/Application/CryptoPolicy.php';
require dirname(__DIR__) . '/src/Application/SecurityThreatControlMatrix.php';
require dirname(__DIR__) . '/src/Application/SecurityEventEmitter.php';
require dirname(__DIR__) . '/src/Application/PipelineRuntime.php';
require dirname(__DIR__) . '/src/Application/RuntimeTerms.php';
require dirname(__DIR__) . '/src/Policy/PolicyDecisionPointInterface.php';

use Cre8\Application\PipelineRuntime;
use Cre8\Application\SecurityEventEmitter;
use Cre8\Application\SecurityThreatControlMatrix;
use Cre8\Policy\PolicyDecisionPointInterface;

final class AllowPdp implements PolicyDecisionPointInterface {
    public function decide(array $context): array { return ['outcome' => 'Allow', 'reason_code' => 'OK']; }
}

foreach (['THREAT-001', 'THREAT-002', 'THREAT-003'] as $threatId) {
    if (!SecurityThreatControlMatrix::hasPreventiveAndDetectiveCoverage($threatId)) {
        fwrite(STDERR, '[HOOK-SEC-THREAT-CONTROL-MATRIX] missing preventive+detective coverage for ' . $threatId . PHP_EOL);
        exit(1);
    }
}

$emitter = new SecurityEventEmitter();
$runtime = new PipelineRuntime(new AllowPdp(), $emitter);
$ts = gmdate('Y-m-d\TH:i:s\Z');
$req = ['public_key_id'=>'pk1','timestamp'=>$ts,'nonce'=>str_repeat('a',24),'signature'=>'sig', 'request_id'=>'req-abuse-1'];
$first = $runtime->handleProtected($req);
if (!isset($first['data']['accepted']) || $first['data']['accepted'] !== true) {
    fwrite(STDERR, '[HOOK-SEC-ABUSE-REPLAY] first request must pass' . PHP_EOL); exit(1);
}
$second = $runtime->handleProtected($req);
if (($second['error']['code'] ?? null) !== 'AUTHN_PROOF_REPLAY_DETECTED') {
    fwrite(STDERR, '[HOOK-SEC-ABUSE-REPLAY] replay not detected' . PHP_EOL); exit(1);
}

$oldTs = gmdate('Y-m-d\TH:i:s\Z', time() - 500);
$invalidTsResponse = $runtime->handleProtected(['public_key_id'=>'pk2','timestamp'=>$oldTs,'nonce'=>str_repeat('b',24),'signature'=>'sig', 'request_id'=>'req-abuse-2']);
if (($invalidTsResponse['error']['code'] ?? null) !== 'AUTHN_PROOF_INVALID_TIMESTAMP') {
    fwrite(STDERR, '[HOOK-SEC-ABUSE-TIMESTAMP] timestamp failure not enforced' . PHP_EOL); exit(1);
}

$events = $emitter->events();
$eventNames = array_column($events, 'event_name');
foreach (['auth.proof.replay_detected.v1', 'auth.proof.timestamp_invalid.v1'] as $expectedEvent) {
    if (!in_array($expectedEvent, $eventNames, true)) {
        fwrite(STDERR, '[HOOK-SEC-OBS-LINKAGE] missing expected security event ' . $expectedEvent . PHP_EOL); exit(1);
    }
}

echo "test:contract:security-abuse PASS (threat_control=validated, abuse_cases=validated, observability=validated)" . PHP_EOL;
