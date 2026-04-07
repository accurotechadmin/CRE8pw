<?php

declare(strict_types=1);

namespace Cre8\Modules\Auth\Interface\Routes;

use Slim\App;

final class AuthRouteProvider
{
    /** @var callable */
    private $postOwnerLoginHandler;
    /** @var callable */
    private $postKeyLoginHandler;

    public function __construct(callable $postOwnerLoginHandler, callable $postKeyLoginHandler)
    {
        $this->postOwnerLoginHandler = $postOwnerLoginHandler;
        $this->postKeyLoginHandler = $postKeyLoginHandler;
    }

    public function register(App $app): void
    {
        $app->post('/api/auth/login', $this->postOwnerLoginHandler);
        $app->post('/api/auth/key-login', $this->postKeyLoginHandler);
    }
}
