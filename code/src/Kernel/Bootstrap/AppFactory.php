<?php

declare(strict_types=1);

namespace Cre8\Kernel\Bootstrap;

use Cre8\Kernel\Http\EnvelopeResponder;
use Cre8\Modules\Auth\Application\UseCases\LoginOwner;
use Cre8\Modules\Auth\Application\UseCases\LoginKey;
use Cre8\Modules\Auth\Domain\Policies\KeyCredentialPolicy;
use Cre8\Modules\Auth\Domain\Policies\OwnerCredentialPolicy;
use Cre8\Modules\Auth\Domain\Policies\TokenSurfacePolicy;
use Cre8\Modules\Auth\Interface\Http\Handlers\PostKeyLoginHandler;
use Cre8\Modules\Auth\Interface\Http\Handlers\PostOwnerLoginHandler;
use Cre8\Modules\Auth\Interface\Routes\AuthRouteProvider;
use Cre8\Modules\Health\Application\UseCases\GetHealthStatus;
use Cre8\Modules\Health\Application\UseCases\GetStatus;
use Cre8\Modules\Health\Interface\Http\Handlers\GetHealthHandler;
use Cre8\Modules\Health\Interface\Http\Handlers\GetStatusHandler;
use Cre8\Modules\Health\Interface\Routes\HealthRouteProvider;
use Cre8\Modules\Health\Interface\Routes\StatusRouteProvider;
use Slim\Factory\AppFactory as SlimAppFactory;
use Slim\Psr7\Factory\ResponseFactory;

final class AppFactory
{
    public function create(): \Slim\App
    {
        $app = SlimAppFactory::create();

        $responder = new EnvelopeResponder(new ResponseFactory());

        $statusHandler = new GetStatusHandler(new GetStatus(), $responder);
        (new StatusRouteProvider($statusHandler))->register($app);

        $healthHandler = new GetHealthHandler(new GetHealthStatus(), $responder);
        (new HealthRouteProvider($healthHandler))->register($app);

        $ownerCredentials = new OwnerCredentialPolicy([
            'owner@example.com' => 'StrongPassphrase123!',
        ]);
        $keyCredentials = new KeyCredentialPolicy([
            'key_123' => 'cre8k_secret',
        ]);
        $tokenPolicy = new TokenSurfacePolicy();

        $loginHandler = new PostOwnerLoginHandler(
            new LoginOwner($ownerCredentials, $tokenPolicy),
            $responder
        );
        $keyLoginHandler = new PostKeyLoginHandler(
            new LoginKey($keyCredentials, $tokenPolicy),
            $responder
        );
        (new AuthRouteProvider($loginHandler, $keyLoginHandler))->register($app);

        return $app;
    }
}
