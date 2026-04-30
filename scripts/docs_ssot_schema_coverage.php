<?php
$schemas=glob('docs/31_machine_contracts/schemas/*.schema.json');
if(!$schemas){fwrite(STDERR,"[HOOK-CONTRACT-SCHEMA-COVERAGE] FAIL: no schema files found.
"); exit(1);} 
$withAdditional=0;
foreach($schemas as $s){$j=json_decode(file_get_contents($s),true); if(is_array($j)&&array_key_exists('additionalProperties',$j)) $withAdditional++;}
if($withAdditional===0){fwrite(STDERR,"[HOOK-CONTRACT-SCHEMA-COVERAGE] FAIL: no schema declares additionalProperties.
"); exit(1);} 
echo "[HOOK-CONTRACT-SCHEMA-COVERAGE] PASS: schemas=".count($schemas).", top-level additionalProperties declarations={$withAdditional}.
";
