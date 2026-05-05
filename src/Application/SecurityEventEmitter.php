<?php

declare(strict_types=1);

namespace Cre8\Application;

final class SecurityEventEmitter
{
    /** @var array<string,array{channel:string,severity:string,sampling:string,retention:string,sensitivity:string,required_provenance:list<string>}> */
    private const CATALOG = [
        'authz.decision.evaluated.v1' => [
            'channel' => 'security', 'severity' => 'INFO', 'sampling' => 'always', 'retention' => 'audit-365d', 'sensitivity' => 'restricted',
            'required_provenance' => ['principal_id', 'keypair_id', 'delegation_id'],
        ],
        'authz.decision.denied.v1' => [
            'channel' => 'security', 'severity' => 'WARN', 'sampling' => 'always', 'retention' => 'audit-365d', 'sensitivity' => 'restricted',
            'required_provenance' => ['principal_id'],
        ],
        'health.readiness.failed.v1' => [
            'channel' => 'operations', 'severity' => 'ERROR', 'sampling' => 'always', 'retention' => 'operational-30d', 'sensitivity' => 'internal',
            'required_provenance' => [],
        ],
    ];

    /** @var list<array<string,mixed>> */
    private array $events = [];

    public function emit(string $eventName, string $requestId, array $provenance): void
    {
        $rule = self::CATALOG[$eventName] ?? null;
        if ($rule === null) {
            throw new \InvalidArgumentException('Unknown event catalog entry: ' . $eventName);
        }

        foreach ($rule['required_provenance'] as $requiredKey) {
            if (!array_key_exists($requiredKey, $provenance)) {
                throw new \InvalidArgumentException('Missing required provenance key: ' . $requiredKey);
            }
        }

        $redactedProvenance = $this->redact($provenance);

        $this->events[] = [
            'event_name' => $eventName,
            'event_version' => 'v1',
            'severity' => $rule['severity'],
            'channel' => $rule['channel'],
            'sampling' => $rule['sampling'],
            'retention' => $rule['retention'],
            'sensitivity' => $rule['sensitivity'],
            'timestamp_utc' => gmdate('Y-m-d\TH:i:s\Z'),
            'request_id' => $requestId,
            'provenance' => $redactedProvenance,
        ];
    }

    /** @return list<array<string,mixed>> */
    public function events(): array
    {
        return $this->events;
    }

    private function redact(array $payload): array
    {
        $json = json_encode($payload, JSON_THROW_ON_ERROR);
        $json = preg_replace('/(secret|token|private_key|signature)\"\s*:\s*\"[^\"]*\"/i', '$1":"[redacted]"', $json) ?? $json;

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}
