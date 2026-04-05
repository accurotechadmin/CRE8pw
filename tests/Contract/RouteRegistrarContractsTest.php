<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use PHPUnit\Framework\TestCase;

final class RouteRegistrarContractsTest extends TestCase
{
    private const ROOT = __DIR__ . '/../../';

    public function testRouteRegistrarUsesServiceBackedPostAndFeedHandlers(): void
    {
        $registrarPhp = $this->read('src/Http/Routes/RouteRegistrar.php');

        self::assertStringContainsString('registerConsoleRoutes', $registrarPhp);
        self::assertStringContainsString('registerGatewayRoutes', $registrarPhp);
        self::assertStringContainsString('PostsService::class', $registrarPhp);
        self::assertStringContainsString('FeedService::class', $registrarPhp);
        self::assertStringContainsString('AuthService::class', $registrarPhp);
        self::assertStringContainsString('/console/api', $registrarPhp);
        self::assertStringContainsString('/console/owners', $registrarPhp);
        self::assertStringContainsString('/api', $registrarPhp);
        self::assertStringContainsString('/console/api/keys', $registrarPhp);
        self::assertStringContainsString('/console/api/keys/{keyId}/lifecycle', $registrarPhp);
        self::assertStringContainsString('/console/api/posts/{postId}/moderation', $registrarPhp);
        self::assertStringContainsString('/console/api/posts/{postId}/comments/{commentId}/moderation', $registrarPhp);
        self::assertStringContainsString('/api/auth/key-login', $registrarPhp);
        self::assertStringContainsString('/api/posts/{postId}', $registrarPhp);
        self::assertStringContainsString('/api/posts/{postId}/comments', $registrarPhp);
    }

    public function testRouteRegistrarNoLongerUsesEmptyFeedAndPostStubs(): void
    {
        $registrarPhp = $this->read('src/Http/Routes/RouteRegistrar.php');

        self::assertStringNotContainsString("responder->list([], null, 50)", $registrarPhp);
        self::assertStringNotContainsString("responder->success(['id' => bin2hex(random_bytes(16))], 201)", $registrarPhp);
        self::assertStringNotContainsString('rotated_access_stub', $registrarPhp);
        self::assertStringContainsString('visibility_scope', $registrarPhp);
        self::assertStringContainsString("['path' => 'refresh_token'", $registrarPhp);
    }

    public function testRouteRegistrarUsesAuthServiceForLoginAndRefresh(): void
    {
        $registrarPhp = $this->read('src/Http/Routes/RouteRegistrar.php');

        self::assertStringContainsString('->login(', $registrarPhp);
        self::assertStringContainsString('->refresh(', $registrarPhp);
        self::assertStringContainsString('->registerOwner(', $registrarPhp);
        self::assertStringContainsString('AuthException', $registrarPhp);
    }

    private function read(string $path): string
    {
        return (string) file_get_contents(self::ROOT . $path);
    }
}
