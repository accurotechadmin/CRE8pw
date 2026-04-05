<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use PHPUnit\Framework\TestCase;

final class ComposerScriptsContractTest extends TestCase
{
    public function testComposerDefinesQaAndOperationalSmokeScripts(): void
    {
        $composer = json_decode((string) file_get_contents(__DIR__ . '/../../composer.json'), true, 512, JSON_THROW_ON_ERROR);
        $scripts = (array) ($composer['scripts'] ?? []);

        foreach (['test', 'test:contract', 'test:security', 'qa', 'ops:health-smoke', 'ops:migrate-smoke'] as $required) {
            self::assertArrayHasKey($required, $scripts, "missing composer script: {$required}");
        }

        self::assertSame('8.2.0', $composer['config']['platform']['php'] ?? null);
    }
}
