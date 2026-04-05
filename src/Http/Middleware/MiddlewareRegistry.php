<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Psr\Container\ContainerInterface;

final class MiddlewareRegistry
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /** @return list<object> */
    public function global(): array
    {
        return array_map(
            fn (string $class): object => $this->container->get($class),
            array_values(MiddlewareOrder::GLOBAL_CLASS_MAP),
        );
    }

    /** @return array<string, list<object>> */
    public function perSurface(): array
    {
        $resolved = [];
        foreach (MiddlewareOrder::PER_SURFACE_CLASS_MAP as $surface => $classes) {
            $resolved[$surface] = array_map(
                fn (string $class): object => $this->container->get($class),
                $classes,
            );
        }

        return $resolved;
    }

    /** @return list<object> */
    public function forSurface(string $surface): array
    {
        $map = $this->perSurface();

        return $map[$surface] ?? [];
    }
}
