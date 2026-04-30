<?php
$doc='docs/20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md';
if(!is_file($doc)){fwrite(STDERR,"[HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY] FAIL: missing $doc
"); exit(1);} 
$c=file_get_contents($doc);
foreach(['active','suspended','revoked','expired'] as $state){ if(stripos($c,$state)===false){fwrite(STDERR,"[HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY] FAIL: missing state $state.
"); exit(1);} }
echo "[HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY] PASS: required states present in delegation state machine.
";
