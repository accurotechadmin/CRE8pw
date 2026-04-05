<?php

declare(strict_types=1);

namespace Cre8\Tests\Security;

use Cre8\Observability\AuditEmitter;
use Cre8\Security\KeyMaterial;
use PHPUnit\Framework\TestCase;

final class KeyMaterialSecurityTest extends TestCase
{
    public function testResolveAcceptsInlinePemAndEmitsAuditEvent(): void
    {
        $audit = new InMemoryAuditEmitter();
        $pem = "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----";

        $resolved = KeyMaterial::resolve($pem, $audit, 'jwt_public');

        self::assertSame($pem, $resolved);
        self::assertSame('security.key_material.resolved', $audit->events[0]['event']);
        self::assertSame('inline', $audit->events[0]['payload']['source']);
    }

    public function testResolveRejectsWorldWritableFilePermissions(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'keymaterial-');
        file_put_contents($file, "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----\n");
        chmod($file, 0666);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('permissions are too permissive');
        KeyMaterial::resolve($file);
    }

    public function testResolveAllowsGroupWritableButNotWorldWritablePermissions(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'keymaterial-');
        file_put_contents($file, "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----\n");
        chmod($file, 0664);

        try {
            $resolved = KeyMaterial::resolve($file);
            self::assertStringContainsString('BEGIN PUBLIC KEY', $resolved);
        } finally {
            @unlink($file);
        }
    }

    public function testResolveRejectsInvalidPemFormatAndAuditsReason(): void
    {
        $audit = new InMemoryAuditEmitter();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('format is invalid');

        try {
            KeyMaterial::resolve('not-a-key', $audit);
        } finally {
            self::assertSame('security.key_material.rejected', $audit->events[0]['event'] ?? null);
            self::assertSame('key_material_missing', $audit->events[0]['payload']['reason_code'] ?? null);
        }
    }
}

final class InMemoryAuditEmitter implements AuditEmitter
{
    /** @var list<array{event:string,payload:array<string,mixed>}> */
    public array $events = [];

    public function emit(string $event, array $payload = []): void
    {
        $this->events[] = ['event' => $event, 'payload' => $payload];
    }
}
