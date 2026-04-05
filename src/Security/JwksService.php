<?php

declare(strict_types=1);

namespace Cre8\Security;

use Cre8\Config\RuntimeConfig;

final class JwksService
{
    public function __construct(private readonly RuntimeConfig $config)
    {
    }

    /** @return array{keys:list<array<string,mixed>>} */
    public function current(): array
    {
        $publicPem = KeyMaterial::resolve($this->config->jwtPublicKey);
        $resource = openssl_pkey_get_public($publicPem);
        if ($resource === false) {
            throw new \RuntimeException('jwks_key_parse_failed');
        }

        $details = openssl_pkey_get_details($resource);
        if (!is_array($details) || ($details['type'] ?? null) !== OPENSSL_KEYTYPE_RSA || !isset($details['rsa']['n'], $details['rsa']['e'])) {
            throw new \RuntimeException('jwks_key_not_rsa');
        }

        $kid = substr(hash('sha256', $publicPem), 0, 16);

        return [
            'keys' => [[
                'kty' => 'RSA',
                'use' => 'sig',
                'alg' => 'RS256',
                'kid' => $kid,
                'n' => $this->base64Url((string) $details['rsa']['n']),
                'e' => $this->base64Url((string) $details['rsa']['e']),
            ]],
        ];
    }

    private function base64Url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
