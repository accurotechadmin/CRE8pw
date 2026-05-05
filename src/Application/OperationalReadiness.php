<?php

declare(strict_types=1);

namespace Cre8\Application;

final class OperationalReadiness
{
    public function liveness(string $requestId): array
    {
        return [
            'data' => ['status' => 'live'],
            'meta' => $this->meta($requestId),
        ];
    }

    public function readiness(string $requestId, array $checks): array
    {
        $failed = array_values(array_filter($checks, static fn (array $check): bool => ($check['status'] ?? 'fail') !== 'pass'));

        if ($failed === []) {
            return [
                'data' => ['status' => 'ready', 'checks' => $checks],
                'meta' => $this->meta($requestId),
            ];
        }

        return [
            'error' => [
                'code' => 'SYSTEM_DEPENDENCY_UNREADY',
                'message' => 'Readiness checks failed.',
                'details' => array_map(static fn (array $check): array => [
                    'name' => $check['name'] ?? 'unknown',
                    'status' => $check['status'] ?? 'fail',
                ], $failed),
            ],
            'meta' => $this->meta($requestId),
        ];
    }

    private function meta(string $requestId): array
    {
        return [
            'request_id' => $requestId,
            'timestamp_utc' => gmdate('c'),
            'contract_version' => 'v1',
        ];
    }
}
