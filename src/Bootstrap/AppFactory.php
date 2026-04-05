<?php

declare(strict_types=1);

namespace Cre8\Bootstrap;

use Cre8\Http\Middleware\MiddlewareRegistry;
use Cre8\Http\Routes\RouteRegistrar;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory as SlimAppFactory;

final class AppFactory
{
    public static function create(ContainerInterface $container): App
    {
        SlimAppFactory::setContainer($container);
        $app = SlimAppFactory::create();

        $middleware = new MiddlewareRegistry($container);
        foreach (array_reverse($middleware->global()) as $mw) {
            $app->add($mw);
        }

        (new RouteRegistrar())->register($app, $middleware->perSurface());

        return $app;
    }
}
