<?php
$commands = [
    'composer phase2:acceptance-bundle',
    'composer docs:ssot:data-model-coverage',
    'composer docs:ssot:threat-control-matrix',
    'composer docs:ssot:event-catalog-coverage',
    'composer docs:ssot:schema-coverage',
    'composer docs:ssot:example-coverage',
    'composer docs:ssot:openapi-lint',
    'composer docs:ssot:glossary-check',
    'composer docs:ssot:source-refs-check',
    'composer docs:ssot:permission-vocab-resolve',
    'composer docs:ssot:capability-matrix-complete',
    'composer docs:ssot:delegation-sm-consistency',
    'composer test:contract:request-schema',
];
foreach($commands as $cmd){echo "[PHASE3-ACCEPTANCE] running: {$cmd}
"; passthru($cmd,$exit); if($exit!==0){fwrite(STDERR,"[PHASE3-ACCEPTANCE] FAIL: command failed: {$cmd}
"); exit($exit);} }
echo "[PHASE3-ACCEPTANCE] PASS: all commands succeeded.
";
