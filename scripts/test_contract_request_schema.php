<?php
declare(strict_types=1);
$openapi = file_get_contents(dirname(__DIR__) . '/docs/31_machine_contracts/openapi/cre8.v1.yaml');
if ($openapi === false) { fwrite(STDERR,"Missing OpenAPI file.\n"); exit(1);} 
$examples = ['AuthDecisionRequestScopeDeny','AuthDecisionRequestCommentCreate','AuthDecisionRequestMultiAncestorLifecycle'];
foreach ($examples as $ex) {
    if (!preg_match('/'.preg_quote($ex,'/').':\n\s+value:\s*\{([^\n]+)\}/', $openapi, $m)) {
        fwrite(STDERR, "Missing OpenAPI example block: {$ex}\n"); exit(1);
    }
    $line = $m[1];
    foreach (['principal_id','action','resource_scope'] as $k) {
        if (strpos($line, $k . ':') === false) { fwrite(STDERR, "Example {$ex} missing key {$k}\n"); exit(1);}    
    }
}
echo "test:contract:request-schema PASS (examples=3, required_keys=principal_id+action+resource_scope)\n";
