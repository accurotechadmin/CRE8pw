<?php

declare(strict_types=1);

namespace Cre8\Modules\Health\Interface\Routes;

use Cre8\Modules\Health\Interface\Http\Handlers\GetHealthHandler;
use Slim\App;

final class HealthRouteProvider
{
    public function __construct(private readonly GetHealthHandler $getHealthHandler)
    {
    }

    public function register(App $app): void
    {
        $app->get('/health', $this->getHealthHandler);
    }
}
