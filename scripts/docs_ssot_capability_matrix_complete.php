<?php
$doc='docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md';
if(!is_file($doc)){fwrite(STDERR,"[HOOK-CAPABILITY-MATRIX-COMPLETE] FAIL: missing $doc
"); exit(1);} 
$c=file_get_contents($doc);
foreach(['Allow','Deny','Conditional'] as $needle){ if(stripos($c,$needle)===false){fwrite(STDERR,"[HOOK-CAPABILITY-MATRIX-COMPLETE] FAIL: missing matrix state $needle.
"); exit(1);} }
echo "[HOOK-CAPABILITY-MATRIX-COMPLETE] PASS: capability matrix includes allow/deny/conditional states.
";
