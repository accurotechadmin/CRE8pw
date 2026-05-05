<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/Policy/PrincipalTaxonomy.php';
require dirname(__DIR__) . '/src/Policy/PermissionVocabulary.php';
require dirname(__DIR__) . '/src/Policy/KeychainResolver.php';

use Cre8\Policy\KeychainResolver;

$resolver = new KeychainResolver();
$grants = [
    ['grant_id' => 'G-055', 'lifecycle_state' => 'revoked', 'issued_at' => '2026-05-05T06:00:00Z', 'permissions' => ['principal.utility_keypair.rotate']],
    ['grant_id' => 'G-091', 'lifecycle_state' => 'active', 'issued_at' => '2026-05-05T07:00:00Z', 'permissions' => ['principal.utility_keypair.issue']],
    ['grant_id' => 'G-102', 'lifecycle_state' => 'active', 'issued_at' => '2026-05-05T08:00:00Z', 'permissions' => ['principal.utility_keypair.rotate']],
];
$r = $resolver->resolve('DELEGATEE', 'principal.utility_keypair.rotate', $grants);
$errors = [];
if ($r['outcome'] !== 'Allow') {$errors[]='expected Allow';}
if (($r['decision_path'][1] ?? null) !== 'G-102') {$errors[]='expected newest active first in decision_path';}
if (($r['effective_permissions'][0] ?? null) !== 'principal.utility_keypair.rotate') {$errors[]='effective permission mismatch';}
$deny = $resolver->resolve('DELEGATEE', 'principal.utility_keypair.rotate', [['grant_id'=>'G-1','lifecycle_state'=>'suspended','issued_at'=>'2026-05-05T08:00:00Z','permissions'=>['principal.utility_keypair.rotate']]]);
if (($deny['reason_code'] ?? '') !== 'AUTH_DENY_DELEGATION_SCOPE') {$errors[]='missing delegation scope deny';}
if ($errors !== []) {fwrite(STDERR, implode("\n",$errors)."\n"); exit(1);} echo "PASS\n";
