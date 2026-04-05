<?php

declare(strict_types=1);

namespace Cre8\Security;

use Cre8\Observability\AuditEmitter;

final class KeyMaterial
{
    public static function resolve(string $value, ?AuditEmitter $auditEmitter = null, string $label = 'jwt_key'): string
    {
        if (str_starts_with($value, '-----BEGIN')) {
            return self::validatePem($value, $auditEmitter, 'inline', $label);
        }

        if (is_file($value)) {
            self::assertSafePermissions($value);

            $contents = file_get_contents($value);
            if ($contents === false || trim($contents) === '') {
                $auditEmitter?->emit('security.key_material.rejected', [
                    'reason_code' => 'key_material_unreadable',
                    'source' => 'file',
                    'key_label' => $label,
                    'path' => $value,
                ]);
                throw new \RuntimeException('JWT key material could not be read.');
            }

            return self::validatePem($contents, $auditEmitter, 'file', $label, $value);
        }

        $auditEmitter?->emit('security.key_material.rejected', [
            'reason_code' => 'key_material_missing',
            'source' => 'unknown',
            'key_label' => $label,
        ]);

        throw new \RuntimeException('JWT key material is missing.');
    }

    private static function assertSafePermissions(string $path): void
    {
        if (!is_readable($path)) {
            throw new \RuntimeException('JWT key material could not be read.');
        }

        $perms = fileperms($path);
        if ($perms === false) {
            throw new \RuntimeException('JWT key material permission metadata is unavailable.');
        }

        if (($perms & 0o022) !== 0) {
            throw new \RuntimeException('JWT key material permissions are too permissive.');
        }
    }

    private static function validatePem(string $pem, ?AuditEmitter $auditEmitter, string $source, string $label, ?string $path = null): string
    {
        $trimmed = trim($pem);
        if ($trimmed === '' || !preg_match('/^-----BEGIN [A-Z ]+-----[\s\S]+-----END [A-Z ]+-----$/', $trimmed)) {
            $auditEmitter?->emit('security.key_material.rejected', [
                'reason_code' => 'key_material_format_invalid',
                'source' => $source,
                'key_label' => $label,
                'path' => $path,
            ]);

            throw new \RuntimeException('JWT key material format is invalid.');
        }

        $auditEmitter?->emit('security.key_material.resolved', [
            'reason_code' => 'key_material_resolved',
            'source' => $source,
            'key_label' => $label,
            'path' => $path,
        ]);

        return $trimmed;
    }
}
