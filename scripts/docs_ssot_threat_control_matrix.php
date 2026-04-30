<?php
$doc='docs/40_data_security_and_crypto/SECURITY_THREAT_MODEL.md';
$control='docs/40_data_security_and_crypto/SECURITY_CONTROLS_SPEC.md';
foreach ([$doc,$control] as $f){if(!is_file($f)){fwrite(STDERR,"[HOOK-SEC-THREAT-CONTROL-MATRIX] FAIL: missing $f
"); exit(1);} }
$t=file_get_contents($doc); $c=file_get_contents($control);
if (!preg_match('/THREAT-\d{3}/',$t) || !preg_match('/CRE8-SECX-REQ-\d{4}/',$c)) {fwrite(STDERR,"[HOOK-SEC-THREAT-CONTROL-MATRIX] FAIL: missing THREAT or CRE8-SEC requirements.
"); exit(1);} 
echo "[HOOK-SEC-THREAT-CONTROL-MATRIX] PASS: threat-control linkage artifacts present.
";
