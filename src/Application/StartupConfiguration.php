<?php

declare(strict_types=1);

namespace Cre8\Application;

final class StartupConfiguration
{
    /** @return array{ok:bool, code:string, errors:list<string>} */
    public function validate(array $env): array
    {
        $required = ['CRE8_ENV', 'CRE8_DB_DSN', 'CRE8_AUTH_JWT_ISSUER', 'CRE8_AUTH_JWT_AUDIENCE'];
        $errors = [];

        foreach ($required as $name) {
            if (!isset($env[$name]) || trim((string) $env[$name]) === '') {
                $errors[] = sprintf('%s missing', $name);
            }
        }

        if (isset($env['CRE8_AUTH_CLOCK_SKEW_SEC'])) {
            $skew = filter_var($env['CRE8_AUTH_CLOCK_SKEW_SEC'], FILTER_VALIDATE_INT);
            if ($skew === false || $skew < 0 || $skew > 300) {
                $errors[] = 'CRE8_AUTH_CLOCK_SKEW_SEC out of bounds';
            }
        }

        if (isset($env['CRE8_DB_DSN']) && strlen((string) $env['CRE8_DB_DSN']) < 5) {
            $errors[] = 'CRE8_DB_DSN malformed';
        }

        return [
            'ok' => $errors === [],
            'code' => $errors === [] ? 'OK' : 'SYSTEM_STARTUP_FAILED',
            'errors' => $errors,
        ];
    }
}
