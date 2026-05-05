<?php

declare(strict_types=1);

namespace Cre8\Persistence;

final class CoreRelationshipMap
{
    /**
     * @return list<array{parent:string,child:string,cardinality:string,fk_column:string,on_delete:string,on_update:string}>
     */
    public static function erdRows(): array
    {
        return [
            ['parent' => 'principal', 'child' => 'keypair', 'cardinality' => '1:N', 'fk_column' => 'keypair.principal_id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ['parent' => 'principal', 'child' => 'delegation_grant (issuer)', 'cardinality' => '1:N', 'fk_column' => 'delegation_grant.issuer_principal_id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ['parent' => 'principal', 'child' => 'delegation_grant (subject)', 'cardinality' => '1:N', 'fk_column' => 'delegation_grant.subject_principal_id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ['parent' => 'delegation_grant', 'child' => 'delegation_edge (parent)', 'cardinality' => '1:N', 'fk_column' => 'delegation_edge.parent_grant_id', 'on_delete' => 'CASCADE', 'on_update' => 'CASCADE'],
            ['parent' => 'delegation_grant', 'child' => 'delegation_edge (child)', 'cardinality' => '1:N', 'fk_column' => 'delegation_edge.child_grant_id', 'on_delete' => 'CASCADE', 'on_update' => 'CASCADE'],
            ['parent' => 'principal', 'child' => 'audit_event', 'cardinality' => '1:N', 'fk_column' => 'audit_event.actor_principal_id', 'on_delete' => 'SET NULL', 'on_update' => 'CASCADE'],
        ];
    }
}
