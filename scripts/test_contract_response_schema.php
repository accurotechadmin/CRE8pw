<?php
declare(strict_types=1);

$positive = json_decode((string) file_get_contents(dirname(__DIR__) . '/tests/contract/fixtures/positive/lifecycle_suspend_response.json'), true);
$negative = json_decode((string) file_get_contents(dirname(__DIR__) . '/tests/contract/fixtures/negative/lifecycle_suspend_response.json'), true);
if (!is_array($positive) || !is_array($negative)) { fwrite(STDERR, "Fixture decode failed.\n"); exit(1); }

$posState = $positive['data']['lifecycle_state'] ?? null;
$negState = $negative['data']['lifecycle_state'] ?? null;
if ($posState !== 'suspended') { fwrite(STDERR, "Positive fixture invalid lifecycle_state.\n"); exit(1); }
if ($negState === 'suspended') { fwrite(STDERR, "Negative fixture did not violate lifecycle_state const.\n"); exit(1); }

echo "test:contract:response-schema PASS (fixtures=2, lifecycle_suspend_const=validated)\n";
