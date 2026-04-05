<?php

declare(strict_types=1);

namespace Cre8\Observability;

use Psr\Log\LoggerInterface;

final class MonologAuditEmitter implements AuditEmitter
{
    private const SECURITY_EVENT_PREFIXES = ['auth.', 'security.', 'csrf.', 'rate_limit.', 'device_limit.', 'request_id.'];

    public function __construct(
        private readonly LoggerInterface $auditLogger,
        private readonly ?LoggerInterface $securityLogger = null,
        private readonly ?LoggerInterface $failureLogger = null,
    ) {
    }

    public function emit(string $event, array $payload = []): void
    {
        $logger = $this->isSecurityEvent($event) ? ($this->securityLogger ?? $this->auditLogger) : $this->auditLogger;
        $context = $this->normalizeContext($event, $payload);

        try {
            $logger->info($event, $context);
        } catch (\Throwable $exception) {
            $failureContext = [
                'event_name' => 'audit.delivery_failed',
                'event_version' => AuditEmitter::EVENT_VERSION,
                'timestamp_utc' => gmdate('c'),
                'failed_event_name' => $event,
                'failure_reason' => $exception->getMessage(),
            ];

            if ($this->failureLogger !== null) {
                $this->failureLogger->warning('audit.delivery_failed', $failureContext);

                return;
            }

            error_log('audit.delivery_failed ' . (string) json_encode($failureContext, JSON_THROW_ON_ERROR));
        }
    }

    private function isSecurityEvent(string $event): bool
    {
        foreach (self::SECURITY_EVENT_PREFIXES as $prefix) {
            if (str_starts_with($event, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /** @param array<string,mixed> $payload
     *  @return array<string,mixed>
     */
    private function normalizeContext(string $event, array $payload): array
    {
        $context = $this->redact($payload);

        $context['event_name'] = $event;
        $context['event_version'] = (string) ($context['event_version'] ?? AuditEmitter::EVENT_VERSION);
        $context['timestamp_utc'] = (string) ($context['timestamp_utc'] ?? gmdate('c'));

        foreach (AuditEmitter::REQUIRED_FIELDS as $field) {
            if (!array_key_exists($field, $context)) {
                $context[$field] = null;
            }
        }

        return $context;
    }

    /** @param array<string,mixed> $payload
     *  @return array<string,mixed>
     */
    private function redact(array $payload): array
    {
        $redacted = [];

        foreach ($payload as $key => $value) {
            $normalizedKey = strtolower((string) $key);
            if (in_array($normalizedKey, AuditEmitter::REDACTED_FIELD_KEYS, true)) {
                $redacted[$key] = '[REDACTED]';
                continue;
            }

            if (is_array($value)) {
                $redacted[$key] = $this->redact($value);
                continue;
            }

            $redacted[$key] = $value;
        }

        return $redacted;
    }
}
