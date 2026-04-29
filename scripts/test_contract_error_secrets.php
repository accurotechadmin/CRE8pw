<?php

declare(strict_types=1);

$openApiPath = dirname(__DIR__) . '/docs/31_machine_contracts/openapi/cre8.v1.yaml';
$content = file_get_contents($openApiPath);
if ($content === false) {
    fwrite(STDERR, "[HOOK-CONTRACT-ERROR-SECRETS-REDaction] unable to read OpenAPI contract" . PHP_EOL);
    exit(1);
}

$forbidden = ['private_key', 'seed_phrase', 'stack_trace', 'exception', 'password', 'secret'];
$violations = [];
foreach ($forbidden as $token) {
    if (stripos($content, $token) !== false) {
        $violations[] = "[HOOK-CONTRACT-ERROR-SECRETS-REDaction] forbidden token found in OpenAPI contract: {$token}";
    }
}

if (!str_contains($content, 'description: Internal error (redacted response).')) {
    $violations[] = '[HOOK-CONTRACT-ERROR-SECRETS-REDaction] expected redacted 5xx error description not found';
}

if ($violations !== []) {
    foreach ($violations as $v) fwrite(STDERR, $v . PHP_EOL);
    exit(1);
}

echo 'test:contract:error-secrets PASS (redaction_clauses=present)' . PHP_EOL;
