<?php

declare(strict_types=1);

namespace Cre8\Modules\Health\Interface\Routes;

use Slim\App;

final class StatusRouteProvider
{
    /** @var callable */
    private $getStatusHandler;

    public function __construct(callable $getStatusHandler)
    {
        $this->getStatusHandler = $getStatusHandler;
    }

    public function register(App $app): void
    {
        $app->get('/', $this->getStatusHandler);
    }
}
