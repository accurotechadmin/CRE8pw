<?php

declare(strict_types=1);

namespace Cre8\Tests\Unit\Modules\Health;

use Cre8\Modules\Health\Application\UseCases\GetHealthStatus;
use PHPUnit\Framework\TestCase;

final class GetHealthStatusTest extends TestCase
{
    public function testItReturnsSsotHealthShape(): void
    {
        $result = (new GetHealthStatus())->execute();

        self::assertSame('ok', $result['status']);
        self::assertMatchesRegularExpression('/^\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}Z$/', $result['checked_at_utc']);
        self::assertIsInt($result['latency_ms']);
        self::assertSame([], $result['failures']);

        foreach (['db', 'rate_limiter', 'key_material', 'http_dependency'] as $service) {
            self::assertArrayHasKey($service, $result['services']);
            self::assertSame('ok', $result['services'][$service]['status']);
        }
    }
}
