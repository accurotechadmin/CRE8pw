<?php
declare(strict_types=1);
$txt = file_get_contents(dirname(__DIR__) . '/docs/31_machine_contracts/openapi/cre8.v1.yaml');
if ($txt === false) { fwrite(STDERR, "Cannot read OpenAPI file.\n"); exit(1);} 
$errors=[];
if (!preg_match('/^openapi:\s*3\.1\.0/m',$txt)) $errors[]='openapi version must be 3.1.0';
$authzPattern = '/\/v1\/authz\/decide:\n\s+post:.*?requestBody:\n\s+required:\s+true\n\s+content:\n\s+application\/json:\n\s+schema:\n\s+\$ref:\s+\.\.\/schemas\/policy-decision\.schema\.json\n\s+examples:\n/s';
if (!preg_match($authzPattern, $txt)) $errors[]='authz requestBody must place examples as media-type sibling of schema';
if ($errors){foreach($errors as $e) fwrite(STDERR,"[HOOK-OPENAPI-LINT] $e\n"); exit(1);} 
echo "docs:ssot:openapi-lint PASS (authz requestBody structural check)\n";
