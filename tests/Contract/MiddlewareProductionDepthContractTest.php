<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Http\Middleware\CorsMiddleware;
use Cre8\Http\Middleware\CsrfMiddleware;
use Cre8\Http\Middleware\DeviceLimitMiddleware;
use Cre8\Http\Middleware\ErrorHandlerMiddleware;
use Cre8\Http\Middleware\JsonBodyMiddleware;
use Cre8\Http\Middleware\KeyJwtMiddleware;
use Cre8\Http\Middleware\OwnerJwtMiddleware;
use Cre8\Http\Middleware\RateLimitMiddleware;
use Cre8\Http\Middleware\RequestIdMiddleware;
use Cre8\Http\Middleware\RoutingMarkerMiddleware;
use Cre8\Http\Middleware\SecurityHeadersMiddleware;
use Cre8\Http\Middleware\UseKeyLimitMiddleware;
use Cre8\Http\Middleware\ValidationMiddleware;
use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\TokenVerificationResult;
use Cre8\Security\TokenVerifier;
use Cre8\Security\VerifiedPrincipal;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\InMemoryStorage;

final class MiddlewareProductionDepthContractTest extends TestCase
{
    public function testRequestIdMiddlewareReplacesInvalidIncomingHeaderAndAuditsReplacement(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new RequestIdMiddleware($audit);

        $response = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/posts')->withHeader('X-Request-Id', 'not-a-uuid'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                $response = (new ResponseFactory())->createResponse(200);
                $response->getBody()->write((string) $request->getAttribute('request_id_source'));

                return $response;
            }),
        );

        self::assertSame('generated', (string) $response->getBody());
        self::assertMatchesRegularExpression('/^[0-9a-f-]{36}$/', $response->getHeaderLine('X-Request-Id'));
        self::assertSame('request_id.invalid_replaced', $audit->events[0]['event']);
    }

    public function testRoutingMarkerMiddlewareSetsSurfaceAndRouteFamilyForConsoleAndGateway(): void
    {
        $middleware = new RoutingMarkerMiddleware();

        $console = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/console/api/posts'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                $response = (new ResponseFactory())->createResponse(200);
                $response->getBody()->write((string) $request->getAttribute('route_surface') . ':' . (string) $request->getAttribute('route_family'));

                return $response;
            }),
        );
        self::assertSame('console:posts', (string) $console->getBody());

        $gateway = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/feed'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                $response = (new ResponseFactory())->createResponse(200);
                $response->getBody()->write((string) $request->getAttribute('route_surface') . ':' . (string) $request->getAttribute('route_family'));

                return $response;
            }),
        );
        self::assertSame('gateway:feed', (string) $gateway->getBody());
    }

    public function testSecurityHeadersMiddlewareAddsModernHeadersWithoutOverridingExistingCsp(): void
    {
        $middleware = new SecurityHeadersMiddleware();

        $response = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/feed'),
            new CallableHandler(static function (): ResponseInterface {
                return (new ResponseFactory())
                    ->createResponse(200)
                    ->withHeader('Content-Security-Policy', "default-src 'self'");
            }),
        );

        self::assertSame("default-src 'self'", $response->getHeaderLine('Content-Security-Policy'));
        self::assertSame('same-origin', $response->getHeaderLine('Cross-Origin-Opener-Policy'));
        self::assertSame('same-origin', $response->getHeaderLine('Cross-Origin-Resource-Policy'));
        self::assertSame('accelerometer=(), camera=(), geolocation=(), microphone=()', $response->getHeaderLine('Permissions-Policy'));
    }

    public function testErrorHandlerMiddlewareReturnsMappedErrorCodesAndDetailCodes(): void
    {
        $responder = new EnvelopeResponder(new ResponseFactory());
        $middleware = new ErrorHandlerMiddleware($responder);

        $notFound = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/')->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                throw new HttpNotFoundException($request);
            }),
        );

        self::assertSame(404, $notFound->getStatusCode());
        $notFoundPayload = (array) json_decode((string) $notFound->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('not_found', $notFoundPayload['error']['code']);
        self::assertSame('route_not_found', $notFoundPayload['error']['details']['detail_code']);

        $methodNotAllowed = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('POST', '/health')->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                throw new HttpMethodNotAllowedException($request);
            }),
        );

        self::assertSame(405, $methodNotAllowed->getStatusCode());
        $methodNotAllowedPayload = (array) json_decode((string) $methodNotAllowed->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('method_not_allowed', $methodNotAllowedPayload['error']['code']);
        self::assertSame('route_method_not_allowed', $methodNotAllowedPayload['error']['details']['detail_code']);

        $unauthorized = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/feed')->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                throw new HttpUnauthorizedException($request);
            }),
        );

        self::assertSame(401, $unauthorized->getStatusCode());
        $unauthorizedPayload = (array) json_decode((string) $unauthorized->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('unauthorized', $unauthorizedPayload['error']['code']);
        self::assertSame('http_unauthorized', $unauthorizedPayload['error']['details']['detail_code']);

        $badRequest = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('POST', '/api/posts')->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static function (): ResponseInterface {
                throw new \InvalidArgumentException('bad input');
            }),
        );

        self::assertSame(400, $badRequest->getStatusCode());
        $payload = (array) json_decode((string) $badRequest->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('bad_request', $payload['error']['code']);
        self::assertSame('invalid_argument', $payload['error']['details']['detail_code']);

        $internal = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/feed')->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static function (): ResponseInterface {
                throw new \RuntimeException('boom');
            }),
        );

        self::assertSame(500, $internal->getStatusCode());
        $internalPayload = (array) json_decode((string) $internal->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('unhandled_exception', $internalPayload['error']['details']['detail_code']);
    }

    public function testCorsMiddlewareRejectsDisallowedPreflightWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new CorsMiddleware($this->runtimeConfig(), new ResponseFactory(), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('OPTIONS', '/api/feed')
                ->withHeader('Origin', 'https://evil.example')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(403, $response->getStatusCode());
        self::assertSame('cors_origin_disallowed', $response->getHeaderLine('X-Cors-Error-Code'));
        self::assertSame('cors.preflight_rejected', $audit->events[0]['event']);
    }

    public function testCsrfMiddlewareReturnsMalformedDetailCodeAndAudits(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new CsrfMiddleware($this->runtimeConfig(), new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/console/api/posts')
                ->withHeader('X-CSRF-Token', 'not-hex')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(403, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('csrf_token_malformed', $payload['error']['details']['detail_code']);
        self::assertSame('csrf.rejected', $audit->events[0]['event']);
    }

    public function testDeviceLimitMiddlewareRejectsInvalidHeaderFormatWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new DeviceLimitMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('GET', '/api/feed')
                ->withHeader('X-Device-Id', 'bad')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(422, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('device_id_invalid_format', $payload['error']['details'][0]['detail_code']);
        self::assertSame('device_limit.rejected', $audit->events[0]['event']);
    }

    public function testJsonBodyMiddlewareRejectsJsonArrayPayloadRootAndAudits(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new JsonBodyMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/api/posts')
                ->withHeader('Content-Type', 'application/json')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111')
                ->withBody(\Slim\Psr7\Stream::create('[1,2]')),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(400, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('json_root_not_object', $payload['error']['details']['detail_code']);
        self::assertSame('json_body.rejected', $audit->events[0]['event']);
    }

    public function testKeyJwtMiddlewareRejectsWrongAudienceWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new KeyJwtMiddleware(
            new StubTokenVerifier(['typ' => 'key', 'aud' => 'console']),
            $this->runtimeConfig(),
            new EnvelopeResponder(new ResponseFactory()),
            $audit,
        );

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('GET', '/api/feed')
                ->withHeader('Authorization', 'Bearer token')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(401, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('token_audience_invalid', $payload['error']['details']['detail_code']);
        self::assertSame('auth.key_jwt.rejected', $audit->events[0]['event']);
    }

    public function testOwnerJwtMiddlewareRejectsWrongTypeWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new OwnerJwtMiddleware(
            new StubTokenVerifier(['typ' => 'key', 'aud' => 'console']),
            $this->runtimeConfig(),
            new EnvelopeResponder(new ResponseFactory()),
            $audit,
        );

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('GET', '/console/api/posts')
                ->withHeader('Authorization', 'Bearer token')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(401, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('token_type_invalid', $payload['error']['details']['detail_code']);
        self::assertSame('auth.owner_jwt.rejected', $audit->events[0]['event']);
    }

    public function testRateLimitMiddlewareReturnsDeterministicDetailCodeAndAuditWhenRejected(): void
    {
        $audit = new InMemoryAuditEmitter();
        $limiterFactory = new RateLimiterFactory(['id' => 'test', 'policy' => 'fixed_window', 'limit' => 1, 'interval' => '1 minute'], new InMemoryStorage());
        $middleware = new RateLimitMiddleware($limiterFactory, new EnvelopeResponder(new ResponseFactory()), $audit);

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/api/feed')
            ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111');

        $first = $middleware->process(
            $request,
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );
        self::assertSame(200, $first->getStatusCode());

        $second = $middleware->process(
            $request,
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );
        self::assertSame(429, $second->getStatusCode());
        $payload = (array) json_decode((string) $second->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('rate_limit_exceeded', $payload['error']['details']['detail_code']);
        self::assertSame('rate_limit.rejected', $audit->events[1]['event']);
    }

    public function testUseKeyLimitMiddlewareRejectsMutationWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new UseKeyLimitMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/api/keys/abc')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111')
                ->withAttribute('principal', ['key_class' => 'use']),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(403, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('use_key_key_mutation_forbidden', $payload['error']['details']['detail_code']);
        self::assertSame('auth.use_key_limit.rejected', $audit->events[0]['event']);
    }

    public function testValidationMiddlewareRejectsNonObjectBodyWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new ValidationMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/api/auth/login')
                ->withParsedBody('invalid')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(422, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('validation_body_not_object', $payload['error']['details'][0]['detail_code']);
        self::assertSame('validation.rejected', $audit->events[0]['event']);
    }

    public function testValidationMiddlewareAuditsAcceptedRouteAfterSuccessfulValidation(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new ValidationMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/api/posts')
                ->withParsedBody(['title' => 'A', 'body' => 'B', 'visibility_scope' => 'public'])
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('validation.accepted', $audit->events[0]['event']);
        self::assertSame('POST /api/posts', $audit->events[0]['payload']['route_key']);
    }

    private function runtimeConfig(): RuntimeConfig
    {
        return new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: 'u',
            dbPass: 'p',
            jwtIssuer: 'https://issuer.example',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: '/tmp/private.pem',
            jwtPublicKey: '/tmp/public.pem',
            corsAllowedOrigins: ['https://app.example'],
            csrfSecret: 'csrf-secret',
        );
    }
}

final class CallableHandler implements RequestHandlerInterface
{
    /** @var \Closure(ServerRequestInterface):ResponseInterface */
    private \Closure $callback;

    /** @param callable(ServerRequestInterface):ResponseInterface $callback */
    public function __construct(callable $callback)
    {
        $this->callback = $callback(...);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->callback)($request);
    }
}

final class InMemoryAuditEmitter implements AuditEmitter
{
    /** @var list<array{event:string,payload:array<string,mixed>}> */
    public array $events = [];

    public function emit(string $event, array $payload = []): void
    {
        $this->events[] = ['event' => $event, 'payload' => $payload];
    }
}

final class StubTokenVerifier implements TokenVerifier
{
    /** @param array<string,mixed> $claims */
    public function __construct(private readonly array $claims)
    {
    }

    public function verify(string $token): TokenVerificationResult
    {
        return new TokenVerificationResult(
            claims: $this->claims,
            principal: new VerifiedPrincipal((string) ($this->claims['sub'] ?? ''), (string) ($this->claims['typ'] ?? ''), (string) ($this->claims['aud'] ?? ''), isset($this->claims['key_class']) ? (string) $this->claims['key_class'] : null),
        );
    }
}
