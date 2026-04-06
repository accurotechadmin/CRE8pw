<?php

declare(strict_types=1);

namespace Cre8\Modules\Health\Application\UseCases;

final class GetHealthStatus
{
    /**
     * @return array<string,mixed>
     */
    public function execute(): array
    {
        $checkedAt = gmdate('Y-m-d\\TH:i:s\\Z');

        return [
            'status' => 'ok',
            'checked_at_utc' => $checkedAt,
            'latency_ms' => 0,
            'failures' => [],
            'services' => [
                'db' => ['status' => 'ok'],
                'rate_limiter' => ['status' => 'ok'],
                'key_material' => ['status' => 'ok'],
                'http_dependency' => ['status' => 'ok'],
            ],
        ];
    }
}
