<?php
$doc='docs/60_operations_quality_and_release/OBSERVABILITY_EVENT_CATALOG.md';
if(!is_file($doc)){fwrite(STDERR,"[HOOK-OBS-EVENT-CATALOG-COVERAGE] FAIL: missing $doc
"); exit(1);} 
$c=file_get_contents($doc);
if(!preg_match('/CRE8-OPS-REQ-\d{4}/',$c)){fwrite(STDERR,"[HOOK-OBS-EVENT-CATALOG-COVERAGE] FAIL: no CRE8-OPS requirements found.
"); exit(1);} 
echo "[HOOK-OBS-EVENT-CATALOG-COVERAGE] PASS: observability event catalog requirement coverage present.
";
