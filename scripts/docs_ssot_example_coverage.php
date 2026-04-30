<?php
$openapi='docs/31_machine_contracts/openapi/cre8.v1.yaml';
if(!is_file($openapi)){fwrite(STDERR,"[HOOK-CONTRACT-EXAMPLE-COVERAGE] FAIL: missing OpenAPI file.
"); exit(1);} 
$c=file_get_contents($openapi);
$examples=substr_count($c,'examples:');
if($examples<1){fwrite(STDERR,"[HOOK-CONTRACT-EXAMPLE-COVERAGE] FAIL: no examples blocks found.
"); exit(1);} 
echo "[HOOK-CONTRACT-EXAMPLE-COVERAGE] PASS: examples_blocks={$examples}.
";
