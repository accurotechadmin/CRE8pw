<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

final class MiddlewareOrder
{
    /** @var list<string> */
    public const GLOBAL = [
        'ErrorHandler',
        'RequestId',
        'SecurityHeaders',
        'CORS',
        'RateLimit',
        'JsonBodyParsing',
        'Routing',
        'Validation',
        'CSRF',
    ];

    /** @var array<string, class-string> */
    public const GLOBAL_CLASS_MAP = [
        'ErrorHandler' => ErrorHandlerMiddleware::class,
        'RequestId' => RequestIdMiddleware::class,
        'SecurityHeaders' => SecurityHeadersMiddleware::class,
        'CORS' => CorsMiddleware::class,
        'RateLimit' => RateLimitMiddleware::class,
        'JsonBodyParsing' => JsonBodyMiddleware::class,
        'Routing' => RoutingMarkerMiddleware::class,
        'Validation' => ValidationMiddleware::class,
        'CSRF' => CsrfMiddleware::class,
    ];

    /** @var array<string, list<class-string>> */
    public const PER_SURFACE_CLASS_MAP = [
        'console' => [OwnerJwtMiddleware::class],
        'gateway' => [
            KeyJwtMiddleware::class,
            DeviceLimitMiddleware::class,
            UseKeyLimitMiddleware::class,
        ],
        'auth' => [],
        'public' => [],
    ];
}
