<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Http\Middleware\MiddlewareOrder;
use Cre8\Http\Middleware\MiddlewareRegistry;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class MiddlewareRegistryContractsTest extends TestCase
{
    public function testGlobalOrderLabelsAndClassMapStayInSync(): void
    {
        self::assertSame(array_keys(MiddlewareOrder::GLOBAL_CLASS_MAP), MiddlewareOrder::GLOBAL);
    }

    public function testRegistryResolvesGlobalAndPerSurfaceMiddlewareFromOrderCatalog(): void
    {
        $container = new class implements ContainerInterface {
            /** @var array<string, object> */
            private array $instances = [];

            public function get(string $id): object
            {
                if (!isset($this->instances[$id])) {
                    $this->instances[$id] = new class($id) {
                        public function __construct(public string $id)
                        {
                        }
                    };
                }

                return $this->instances[$id];
            }

            public function has(string $id): bool
            {
                return true;
            }
        };

        $registry = new MiddlewareRegistry($container);

        $global = $registry->global();
        self::assertSame(
            array_values(MiddlewareOrder::GLOBAL_CLASS_MAP),
            array_map(static fn (object $item): string => $item->id, $global),
        );

        $gateway = $registry->forSurface('gateway');
        self::assertSame(
            MiddlewareOrder::PER_SURFACE_CLASS_MAP['gateway'],
            array_map(static fn (object $item): string => $item->id, $gateway),
        );

        self::assertSame([], $registry->forSurface('unknown-surface'));
    }
}
