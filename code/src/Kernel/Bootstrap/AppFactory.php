<?php

declare(strict_types=1);

namespace Cre8\Kernel\Bootstrap;

use Cre8\Kernel\Http\EnvelopeResponder;
use Cre8\Modules\Auth\Application\UseCases\LoginOwner;
use Cre8\Modules\Auth\Domain\Policies\OwnerCredentialPolicy;
use Cre8\Modules\Auth\Domain\Policies\TokenSurfacePolicy;
use Cre8\Modules\Auth\Interface\Http\Handlers\PostOwnerLoginHandler;
use Cre8\Modules\Auth\Interface\Routes\AuthRouteProvider;
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

        $healthHandler = new GetHealthHandler(new GetHealthStatus(), $responder);
        (new HealthRouteProvider($healthHandler))->register($app);

        $ownerCredentials = new OwnerCredentialPolicy([
            'owner@example.com' => 'StrongPassphrase123!',
        ]);
        $loginHandler = new PostOwnerLoginHandler(
            new LoginOwner($ownerCredentials, new TokenSurfacePolicy()),
            $responder
        );
        (new AuthRouteProvider($loginHandler))->register($app);

        return $app;
    }
}
