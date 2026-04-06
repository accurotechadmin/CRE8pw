<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Interface\Routes;

use Slim\App;

final class AuthRouteProvider
{
    /** @var callable */
    private $postOwnerLoginHandler;

    public function __construct(callable $postOwnerLoginHandler)
    {
        $this->postOwnerLoginHandler = $postOwnerLoginHandler;
    }

    public function register(App $app): void
    {
        $app->post('/api/auth/login', $this->postOwnerLoginHandler);
    }
}
