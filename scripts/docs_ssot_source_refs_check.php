<?php
declare(strict_types=1);
$root = dirname(__DIR__);
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . '/docs'));
$errors=[];
foreach($it as $f){
  if(!$f->isFile()||$f->getExtension()!=='md') continue;
  $txt=file_get_contents($f->getPathname());
  if(!preg_match('/source_seed_refs:\n((?:\s*-\s+[^\n]+\n)+)/',$txt,$m)) continue;
  preg_match_all('/\s*-\s+([^\n]+)/',$m[1],$mm);
  foreach($mm[1] as $ref){
    $ref=trim($ref);
    if($ref===''||str_starts_with($ref,'(none')) continue;
    $path=$root.'/'.$ref;
    if(!file_exists($path)) $errors[]="[HOOK-SOURCE-REFS-INTEGRITY] {$f->getPathname()}: missing {$ref}";
  }
}
if($errors){fwrite(STDERR,implode(PHP_EOL,$errors).PHP_EOL); exit(1);} 
echo "[HOOK-SOURCE-REFS-INTEGRITY] PASS: all source_seed_refs paths resolve".PHP_EOL;
