<?php

declare(strict_types=1);

namespace Cre8\Bootstrap;

use Cre8\Application\Auth\AuthService;
use Cre8\Application\Auth\KeyLifecycleService;
use Cre8\Application\Feed\FeedService;
use Cre8\Application\Health\HealthService;
use Cre8\Application\Posts\CommentsService;
use Cre8\Application\Posts\ModerationService;
use Cre8\Application\Posts\PostsService;
use Cre8\Config\RuntimeConfig;
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
use Cre8\Observability\AuditEmitter;
use Cre8\Observability\MonologAuditEmitter;
use Cre8\Security\ApiKeyHasher;
use Cre8\Security\JwtTokenSigner;
use Cre8\Security\JwtTokenVerifier;
use Cre8\Security\JwksService;
use Cre8\Security\TokenSigner;
use Cre8\Security\TokenVerifier;
use DI\Container;
use DI\ContainerBuilder;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

final class ContainerFactory
{
    public static function build(RuntimeConfig $config): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(self::coreDefinitions($config));
        $builder->addDefinitions(self::securityDefinitions());
        $builder->addDefinitions(self::httpDefinitions());
        $builder->addDefinitions(self::appDefinitions());

        return $builder->build();
    }

    /** @return array<string, mixed> */
    private static function coreDefinitions(RuntimeConfig $config): array
    {
        return [
            RuntimeConfig::class => $config,
            LoggerInterface::class => static function (): LoggerInterface {
                $logger = new Logger('cre8');
                $logger->pushHandler(new StreamHandler('php://stdout'));

                return $logger;
            },
            ClientInterface::class => static fn (): ClientInterface => new Client(['timeout' => 5.0, 'http_errors' => false]),
            PDO::class => static fn () => new PDO($config->dbDsn, $config->dbUser, $config->dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]),
            ResponseFactoryInterface::class => static fn (): ResponseFactoryInterface => new ResponseFactory(),
            EnvelopeResponder::class => \DI\autowire(EnvelopeResponder::class),
            RateLimiterFactory::class => static fn (): RateLimiterFactory => new RateLimiterFactory([
                'id' => $config->rateLimitPolicy?->id ?? 'global',
                'policy' => $config->rateLimitPolicy?->policy ?? 'fixed_window',
                'interval' => $config->rateLimitPolicy?->interval ?? '1 minute',
                'limit' => $config->rateLimitPolicy?->limit ?? 180,
            ], new CacheStorage(new ArrayAdapter())),
        ];
    }

    /** @return array<string, mixed> */
    private static function securityDefinitions(): array
    {
        return [
            TokenVerifier::class => \DI\autowire(JwtTokenVerifier::class),
            TokenSigner::class => \DI\autowire(JwtTokenSigner::class),
            ApiKeyHasher::class => \DI\autowire(ApiKeyHasher::class),
            JwksService::class => \DI\autowire(JwksService::class),
            AuditEmitter::class => \DI\autowire(MonologAuditEmitter::class),
        ];
    }

    /** @return array<string, mixed> */
    private static function httpDefinitions(): array
    {
        return [
            ErrorHandlerMiddleware::class => \DI\autowire(ErrorHandlerMiddleware::class),
            RequestIdMiddleware::class => \DI\autowire(RequestIdMiddleware::class),
            SecurityHeadersMiddleware::class => \DI\autowire(SecurityHeadersMiddleware::class),
            CorsMiddleware::class => \DI\autowire(CorsMiddleware::class),
            RateLimitMiddleware::class => \DI\autowire(RateLimitMiddleware::class),
            JsonBodyMiddleware::class => \DI\autowire(JsonBodyMiddleware::class),
            RoutingMarkerMiddleware::class => \DI\autowire(RoutingMarkerMiddleware::class),
            ValidationMiddleware::class => \DI\autowire(ValidationMiddleware::class),
            CsrfMiddleware::class => \DI\autowire(CsrfMiddleware::class),
            OwnerJwtMiddleware::class => \DI\autowire(OwnerJwtMiddleware::class),
            KeyJwtMiddleware::class => \DI\autowire(KeyJwtMiddleware::class),
            DeviceLimitMiddleware::class => \DI\autowire(DeviceLimitMiddleware::class),
            UseKeyLimitMiddleware::class => \DI\autowire(UseKeyLimitMiddleware::class),
        ];
    }

    /** @return array<string, mixed> */
    private static function appDefinitions(): array
    {
        return [
            HealthService::class => \DI\autowire(HealthService::class),
            AuthService::class => \DI\autowire(AuthService::class),
            KeyLifecycleService::class => \DI\autowire(KeyLifecycleService::class),
            PostsService::class => \DI\autowire(PostsService::class),
            CommentsService::class => \DI\autowire(CommentsService::class),
            ModerationService::class => \DI\autowire(ModerationService::class),
            FeedService::class => \DI\autowire(FeedService::class),
        ];
    }
}
