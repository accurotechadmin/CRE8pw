<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RoutingMarkerMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly ?AuditEmitter $auditEmitter = null)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $surface = $this->detectSurface($path);
        $routeFamily = $this->routeFamily($path);

        $this->auditEmitter?->emit('routing.marker.applied', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'surface' => $surface,
            'route_family' => $routeFamily,
            'path' => $path,
        ]);

        return $handler->handle($request
            ->withAttribute('route_surface', $surface)
            ->withAttribute('route_family', $routeFamily));
    }

    private function detectSurface(string $path): string
    {
        if (str_starts_with($path, '/console/api')) {
            return 'console';
        }

        if (str_starts_with($path, '/api')) {
            return 'gateway';
        }

        return 'public';
    }

    private function routeFamily(string $path): string
    {
        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if ($segments === []) {
            return 'root';
        }

        if (($segments[0] ?? '') === 'console' && ($segments[1] ?? '') === 'api') {
            return $segments[2] ?? 'console_root';
        }

        if (($segments[0] ?? '') === 'api') {
            return $segments[1] ?? 'api_root';
        }

        return $segments[0];
    }
}
