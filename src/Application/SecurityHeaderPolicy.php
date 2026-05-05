<?php

declare(strict_types=1);

namespace Cre8\Application;

final class SecurityHeaderPolicy
{
    /** @return array<string,string> */
    public static function forSurface(string $surface, ?string $nonce = null): array
    {
        $headers = [
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
            'X-Content-Type-Options' => 'nosniff',
        ];

        if ($surface === 'owner_console') {
            $headers['X-Frame-Options'] = 'DENY';
            $headers['Referrer-Policy'] = 'strict-origin-when-cross-origin';
            $noncePart = $nonce !== null ? " script-src 'self' 'nonce-{$nonce}'" : '';
            $headers['Content-Security-Policy'] = "default-src 'self';{$noncePart}; object-src 'none'; frame-ancestors 'none'";
        }

        return $headers;
    }
}
