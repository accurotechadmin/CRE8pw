<?php

declare(strict_types=1);

namespace Cre8\Observability;

interface AuditEmitter
{
    public const EVENT_VERSION = '1.0';

    /** @var list<string> */
    public const REQUIRED_FIELDS = [
        'event_name',
        'event_version',
        'timestamp_utc',
        'request_id',
        'trace_id',
        'actor_id',
        'actor_type',
        'target_type',
        'target_id',
        'decision',
        'outcome',
        'reason_code',
    ];

    /** @var list<string> */
    public const REDACTED_FIELD_KEYS = [
        'authorization',
        'bearer',
        'token',
        'password',
        'secret',
        'private_key',
        'refresh_token',
    ];

    public function emit(string $event, array $payload = []): void;
}
