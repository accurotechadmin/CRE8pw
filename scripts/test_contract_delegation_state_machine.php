<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/Policy/DelegationStateMachine.php';
use Cre8\Policy\DelegationStateMachine;
$sm = new DelegationStateMachine();
$errors=[];
$ok=$sm->transition('active','suspend',['actor_authorized'=>true,'lifecycle_guard_ok'=>true,'time_guard_ok'=>true]);
if (($ok['outcome'] ?? '') !== 'ALLOW_TRANSITION' || ($ok['to_state'] ?? '') !== 'suspended') {$errors[]='active suspend should allow';}
$deny=$sm->transition('active','suspend',['actor_authorized'=>false]);
if (($deny['outcome'] ?? '') !== 'DENY_TRANSITION' || ($deny['failure_gate'] ?? '') !== 'actor_authority') {$errors[]='actor authority failure gate mismatch';}
$illegal=$sm->transition('retired','grant');
if (($illegal['reason_code'] ?? '') !== 'AUTH_LIFECYCLE_BLOCKED') {$errors[]='illegal transition code mismatch';}
if ($errors !== []) {fwrite(STDERR, implode("\n",$errors)."\n"); exit(1);} echo "PASS\n";
