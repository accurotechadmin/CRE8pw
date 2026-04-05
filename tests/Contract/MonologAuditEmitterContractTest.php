<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Observability\MonologAuditEmitter;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;

final class MonologAuditEmitterContractTest extends TestCase
{
    public function testEmitterNormalizesRequiredSchemaFieldsAndRedactsSensitiveValues(): void
    {
        $auditLogger = new InMemoryLogger();
        $securityLogger = new InMemoryLogger();
        $emitter = new MonologAuditEmitter($auditLogger, $securityLogger);

        $emitter->emit('auth.login_success', [
            'request_id' => '11111111-1111-4111-8111-111111111111',
            'password' => 'should-never-leak',
            'nested' => ['token' => 'abc123'],
        ]);

        self::assertCount(1, $securityLogger->records);
        self::assertCount(0, $auditLogger->records);
        self::assertSame('[REDACTED]', $securityLogger->records[0]['context']['password']);
        self::assertSame('[REDACTED]', $securityLogger->records[0]['context']['nested']['token']);
        self::assertSame('auth.login_success', $securityLogger->records[0]['context']['event_name']);
        self::assertArrayHasKey('timestamp_utc', $securityLogger->records[0]['context']);
        self::assertArrayHasKey('reason_code', $securityLogger->records[0]['context']);
    }

    public function testEmitterWritesDeliveryFailureEventToFailureLogger(): void
    {
        $auditLogger = new ThrowingLogger();
        $failureLogger = new InMemoryLogger();
        $emitter = new MonologAuditEmitter($auditLogger, null, $failureLogger);

        $emitter->emit('posts.updated', ['request_id' => '11111111-1111-4111-8111-111111111111']);

        self::assertCount(1, $failureLogger->records);
        self::assertSame('warning', $failureLogger->records[0]['level']);
        self::assertSame('audit.delivery_failed', $failureLogger->records[0]['message']);
        self::assertSame('posts.updated', $failureLogger->records[0]['context']['failed_event_name']);
    }
}

final class InMemoryLogger extends AbstractLogger
{
    /** @var list<array{level:string,message:string,context:array<string,mixed>}> */
    public array $records = [];

    public function log($level, $message, array $context = []): void
    {
        $this->records[] = ['level' => (string) $level, 'message' => (string) $message, 'context' => $context];
    }
}

final class ThrowingLogger extends AbstractLogger
{
    public function log($level, $message, array $context = []): void
    {
        throw new \RuntimeException('logger unavailable');
    }
}

