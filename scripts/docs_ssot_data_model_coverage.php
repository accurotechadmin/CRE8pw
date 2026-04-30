<?php
$docs = [
    'docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md',
    'docs/40_data_security_and_crypto/DATA_MODEL_REFERENCE.md',
    'docs/40_data_security_and_crypto/ERD.md',
];
foreach ($docs as $doc) {
    if (!is_file($doc)) {fwrite(STDERR,"[HOOK-DATA-MODEL-COVERAGE] FAIL: missing $doc
"); exit(1);}    
    $content = file_get_contents($doc);
    if (!preg_match('/CRE8-DATA-REQ-\d{4}/', $content)) {fwrite(STDERR,"[HOOK-DATA-MODEL-COVERAGE] FAIL: no CRE8-DATA requirement in $doc
"); exit(1);}    
}
echo "[HOOK-DATA-MODEL-COVERAGE] PASS: data-model docs and requirement IDs present.
";
