<?php

declare(strict_types=1);

namespace Cre8\Kernel\Bootstrap;

use Cre8\Kernel\Http\EnvelopeResponder;
use Cre8\Modules\Health\Application\UseCases\GetHealthStatus;
use Cre8\Modules\Health\Interface\Http\Handlers\GetHealthHandler;
use Cre8\Modules\Health\Interface\Routes\HealthRouteProvider;
use Slim\Factory\AppFactory as SlimAppFactory;
use Slim\Psr7\Factory\ResponseFactory;

final class AppFactory
{
    public function create(): \Slim\App
    {
        $app = SlimAppFactory::create();

        $responder = new EnvelopeResponder(new ResponseFactory());
        $handler = new GetHealthHandler(new GetHealthStatus(), $responder);

        (new HealthRouteProvider($handler))->register($app);

        return $app;
    }
}
