<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use PHPUnit\Framework\TestCase;

final class PublicIndexBootstrapContractTest extends TestCase
{
    public function testIndexHasStartupFailureEnvelopeAndAuditLogging(): void
    {
        $index = (string) file_get_contents(__DIR__ . '/../../public/index.php');

        self::assertStringContainsString('boot.startup_ready', $index);
        self::assertStringContainsString('boot.startup_failed', $index);
        self::assertStringContainsString('catch (\\Throwable $e)', $index);
        self::assertStringContainsString("'code' => 'boot_failed'", $index);
        self::assertStringContainsString("header('X-Request-Id: '", $index);
        self::assertStringContainsString('function loadRuntimeEnv()', $index);
        self::assertStringContainsString('$value = getenv($key);', $index);
        self::assertStringContainsString('$config = RuntimeConfig::fromEnv(loadRuntimeEnv());', $index);
    }
}