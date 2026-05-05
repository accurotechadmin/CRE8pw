<?php

declare(strict_types=1);

namespace Cre8\Application;

final class SecurityEventEmitter
{
    /** @var list<array<string,mixed>> */
    private array $events = [];

    public function emit(string $eventName, string $requestId, array $provenance, string $severity = 'WARN'): void
    {
        $this->events[] = [
            'event_name' => $eventName,
            'event_version' => 'v1',
            'severity' => $severity,
            'channel' => 'security',
            'timestamp_utc' => gmdate('Y-m-d\TH:i:s\Z'),
            'request_id' => $requestId,
            'provenance' => $provenance,
        ];
    }

    /** @return list<array<string,mixed>> */
    public function events(): array
    {
        return $this->events;
    }
}
