<?php
$doc='docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md';
if(!is_file($doc)){fwrite(STDERR,"[HOOK-PERMISSION-VOCAB-RESOLVE] FAIL: missing $doc
"); exit(1);} 
$c=file_get_contents($doc);
if(!preg_match('/CRE8-[A-Z]+-REQ-\d{4}/',$c)){fwrite(STDERR,"[HOOK-PERMISSION-VOCAB-RESOLVE] FAIL: no auth requirements found.
"); exit(1);} 
echo "[HOOK-PERMISSION-VOCAB-RESOLVE] PASS: permission vocabulary requirements present.
";
