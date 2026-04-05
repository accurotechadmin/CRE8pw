<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class SecurityHeadersMiddleware implements MiddlewareInterface
{
    /** @var array<string,string> */
    private const DEFAULT_HEADERS = [
        'X-Frame-Options' => 'DENY',
        'X-Content-Type-Options' => 'nosniff',
        'Referrer-Policy' => 'no-referrer',
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        'Cross-Origin-Opener-Policy' => 'same-origin',
        'Cross-Origin-Resource-Policy' => 'same-origin',
        'Permissions-Policy' => 'accelerometer=(), camera=(), geolocation=(), microphone=()'
    ];
    private const API_CSP = "default-src 'none'; frame-ancestors 'none'";
    private const UI_CSP = "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:; font-src 'self'; connect-src 'self'; frame-ancestors 'none'; base-uri 'none'; form-action 'self'";

    public function __construct(private readonly ?AuditEmitter $auditEmitter = null)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (! $response->hasHeader('Content-Security-Policy')) {
            $path = $request->getUri()->getPath();
            $csp = str_starts_with($path, '/ui') ? self::UI_CSP : self::API_CSP;
            $response = $response->withHeader('Content-Security-Policy', $csp);
        }

        foreach (self::DEFAULT_HEADERS as $name => $value) {
            if (! $response->hasHeader($name)) {
                $response = $response->withHeader($name, $value);
            }
        }

        $this->auditEmitter?->emit('security_headers.applied', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
        ]);

        return $response;
    }
}
