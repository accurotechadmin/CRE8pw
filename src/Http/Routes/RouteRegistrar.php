<?php

declare(strict_types=1);

namespace Cre8\Http\Routes;

use Cre8\Application\Auth\AuthException;
use Cre8\Application\Auth\AuthService;
use Cre8\Application\Auth\KeyLifecycleService;
use Cre8\Application\Feed\FeedService;
use Cre8\Application\Health\HealthService;
use Cre8\Application\Posts\CommentsService;
use Cre8\Application\Posts\ModerationService;
use Cre8\Application\Posts\PostsService;
use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Security\JwksService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

final class RouteRegistrar
{
    /** @param array<string, list<object>> $perSurfaceMiddleware */
    public function register(App $app, array $perSurfaceMiddleware = []): void
    {
        $container = $app->getContainer();
        if ($container === null) {
            throw new \RuntimeException('Container is required for route registration.');
        }

        $responder = $container->get(EnvelopeResponder::class);

        $app->get('/', function ($request, $response) use ($responder) {
            return $responder->success([
                'service' => 'cre8-platform',
                'status' => 'ok',
            ]);
        });

        $app->get('/health', function ($request, $response) use ($container, $responder) {
            $health = $container->get(HealthService::class)->check();

            return $responder->json(200, ['data' => $health]);
        });


        $uiRouteRenderer = \Closure::fromCallable([$this, 'renderUiRoute']);
        $app->get('/ui[/{route:.*}]', function ($request, $response, array $args) use ($uiRouteRenderer) {
            return $uiRouteRenderer(
                $response,
                (string) ($args['route'] ?? ''),
                (string) $request->getUri()->getPath()
            );
        });

        $app->get('/.well-known/jwks.json', function ($request, $response) use ($container, $responder) {
            $jwks = $container->get(JwksService::class)->current();

            return $responder->json(200, $jwks);
        });

        $app->post('/console/owners', function ($request, $response) use ($container, $responder) {
            $body = (array) $request->getParsedBody();
            if (trim((string) ($body['email'] ?? '')) === '' || trim((string) ($body['password'] ?? '')) === '') {
                return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                    ['path' => 'email', 'code' => 'required', 'message' => 'is required'],
                    ['path' => 'password', 'code' => 'required', 'message' => 'is required'],
                ]);
            }

            try {
                $owner = $container->get(AuthService::class)->registerOwner((string) $body['email'], (string) $body['password'], (string) $request->getAttribute('request_id', 'unknown'));
            } catch (AuthException $e) {
                if ($e->getMessage() === 'owner_conflict') {
                    return $responder->error('owner_conflict', 'owner already exists', (string) $request->getAttribute('request_id', 'unknown'), 409, $e->details());
                }

                return $responder->error($e->getMessage(), 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, $e->details());
            }

            return $responder->success($owner, 201);
        });

        $app->post('/api/auth/login', function ($request, $response) use ($container, $responder) {
            $body = (array) $request->getParsedBody();
            if (trim((string) ($body['email'] ?? '')) === '' || trim((string) ($body['password'] ?? '')) === '') {
                return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                    ['path' => 'email', 'code' => 'required', 'message' => 'is required'],
                    ['path' => 'password', 'code' => 'required', 'message' => 'is required'],
                ]);
            }

            try {
                $tokens = $container->get(AuthService::class)->login((string) $body['email'], (string) $body['password'], (string) $request->getAttribute('request_id', 'unknown'));
            } catch (AuthException $e) {
                return $responder->error($e->getMessage(), 'invalid credentials', (string) $request->getAttribute('request_id', 'unknown'), 401, $e->details());
            }

            return $responder->json(200, ['data' => $tokens]);
        });

        $app->post('/api/auth/key-login', function ($request, $response) use ($container, $responder) {
            $body = (array) $request->getParsedBody();
            if (trim((string) ($body['key_id'] ?? '')) === '' || trim((string) ($body['api_key'] ?? '')) === '') {
                return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                    ['path' => 'key_id', 'code' => 'required', 'message' => 'is required'],
                    ['path' => 'api_key', 'code' => 'required', 'message' => 'is required'],
                ]);
            }

            $login = $container->get(KeyLifecycleService::class)->keyLogin(
                (string) $body['key_id'],
                (string) $body['api_key'],
                (string) $request->getAttribute('request_id', 'unknown'),
                fn (array $claims, string $tokenClass, array $context, ?int $ttl): string => $container->get(\Cre8\Security\TokenSigner::class)->sign($claims, $tokenClass, $context, $ttl)
            );

            if ($login === null) {
                return $responder->error('auth_invalid', 'invalid credentials', (string) $request->getAttribute('request_id', 'unknown'), 401, ['reason' => 'api_key_invalid']);
            }

            return $responder->json(200, ['data' => $login]);
        });

        $app->post('/api/auth/refresh', function ($request, $response) use ($container, $responder) {
            $body = (array) $request->getParsedBody();
            if (trim((string) ($body['refresh_token'] ?? '')) === '') {
                return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                    ['path' => 'refresh_token', 'code' => 'required', 'message' => 'is required'],
                ]);
            }

            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            try {
                $tokens = $container->get(AuthService::class)->refresh((string) $body['refresh_token'], $requestId);
            } catch (AuthException $e) {
                if (($e->details()['reason'] ?? null) === 'refresh_surface_mismatch') {
                    try {
                        $tokens = $container->get(KeyLifecycleService::class)->refresh(
                            (string) $body['refresh_token'],
                            $requestId,
                            fn (array $claims, string $tokenClass, array $context, ?int $ttl): string => $container->get(\Cre8\Security\TokenSigner::class)->sign($claims, $tokenClass, $context, $ttl)
                        );
                    } catch (AuthException $keyRefreshException) {
                        return $responder->error($keyRefreshException->getMessage(), 'invalid credentials', $requestId, 401, $keyRefreshException->details());
                    }
                } else {
                    return $responder->error($e->getMessage(), 'invalid credentials', $requestId, 401, $e->details());
                }
            }

            return $responder->json(200, ['data' => $tokens]);
        });

        $this->registerConsoleRoutes($app, $container, $responder, $perSurfaceMiddleware['console'] ?? []);
        $this->registerGatewayRoutes($app, $container, $responder, $perSurfaceMiddleware['gateway'] ?? []);
    }

    private function renderUiRoute(ResponseInterface $response, string $route, string $requestPath = ''): ResponseInterface
    {
        $uiRoot = realpath(dirname(__DIR__, 3).'/public/ui');
        if ($uiRoot === false) {
            $response->getBody()->write('UI not found');

            return $response->withStatus(404)->withHeader('Content-Type', 'text/plain; charset=utf-8');
        }

        $requestedRoute = ltrim($route, '/');
        if ($requestedRoute === '' && str_starts_with($requestPath, '/ui/')) {
            $requestedRoute = ltrim(substr($requestPath, 4), '/');
        }

        if (str_starts_with($requestedRoute, 'ui/')) {
            $requestedRoute = substr($requestedRoute, 3);
        }

        if (pathinfo($requestedRoute, PATHINFO_EXTENSION) !== '') {
            $assetPath = realpath($uiRoot.'/'.$requestedRoute);
            if ($assetPath === false || !is_file($assetPath) || !str_starts_with($assetPath, $uiRoot.DIRECTORY_SEPARATOR)) {
                $response->getBody()->write('UI asset not found');

                return $response->withStatus(404)->withHeader('Content-Type', 'text/plain; charset=utf-8');
            }

            $response->getBody()->write((string) file_get_contents($assetPath));

            return $response->withHeader('Content-Type', $this->uiAssetContentType($assetPath));
        }

        $indexPath = $uiRoot.'/index.html';
        if (!is_file($indexPath)) {
            $response->getBody()->write('UI not found');

            return $response->withStatus(404)->withHeader('Content-Type', 'text/plain; charset=utf-8');
        }

        $response->getBody()->write((string) file_get_contents($indexPath));

        return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }

    private function uiAssetContentType(string $assetPath): string
    {
        return match (strtolower(pathinfo($assetPath, PATHINFO_EXTENSION))) {
            'css' => 'text/css; charset=utf-8',
            'js' => 'application/javascript; charset=utf-8',
            'json' => 'application/json; charset=utf-8',
            'svg' => 'image/svg+xml',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'application/octet-stream',
        };
    }

    /** @param list<object> $surfaceMiddleware */
    private function registerConsoleRoutes(App $app, ContainerInterface $container, EnvelopeResponder $responder, array $surfaceMiddleware): void
    {
        $group = $app->group('/console/api', function ($group) use ($container, $responder) {
            $group->get('/posts', function ($request, $response) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $authorId = (string) ($principal['sub'] ?? 'owner_console');
                $posts = $container->get(PostsService::class)->listForAuthor($authorId);

                return $responder->list($posts, null, 50);
            });

            $group->post('/posts', function ($request, $response) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $authorId = (string) ($principal['sub'] ?? 'owner_console');
                $body = (array) $request->getParsedBody();
                $visibility = (string) ($body['visibility_scope'] ?? 'private');
                $title = trim((string) ($body['title'] ?? ''));
                $postBody = trim((string) ($body['body'] ?? ''));
                $state = (string) ($body['state'] ?? 'published');
                if (!in_array($visibility, ['public', 'private', 'delegated'], true)) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'visibility_scope', 'code' => 'unknown_value', 'message' => 'unsupported visibility scope'],
                    ]);
                }
                if ($title === '' || $postBody === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'title', 'code' => 'required', 'message' => 'is required'],
                        ['path' => 'body', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }

                $post = $container->get(PostsService::class)->create($authorId, $visibility, $title, $postBody, $state);

                return $responder->success($post, 201);
            });

            $group->get('/keychains', function ($request, $response) use ($responder) {
                return $responder->list([], null, 50);
            });

            $group->post('/invites', function ($request, $response) use ($responder) {
                return $responder->success([
                    'invite_id' => bin2hex(random_bytes(16)),
                    'status' => 'created',
                    'created_at_utc' => gmdate('c'),
                ], 201);
            });

            $group->post('/keys', function ($request, $response) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $ownerId = (string) ($principal['sub'] ?? 'owner_console');
                $body = (array) $request->getParsedBody();

                try {
                    $issued = $container->get(KeyLifecycleService::class)->issue($ownerId, [
                        'key_class' => $body['key_class'] ?? null,
                        'parent_envelope_id' => $body['parent_envelope_id'] ?? null,
                        'permissions' => is_array($body['permissions'] ?? null) ? array_map('strval', $body['permissions']) : ['posts:read'],
                        'scope' => is_array($body['scope'] ?? null) ? array_map('strval', $body['scope']) : ['posts:all'],
                        'ttl_seconds' => isset($body['ttl_seconds']) ? (int) $body['ttl_seconds'] : null,
                        'comments_enabled' => (bool) ($body['comments_enabled'] ?? false),
                    ], (string) $request->getAttribute('request_id', 'unknown'));
                } catch (AuthException $e) {
                    $status = $e->getMessage() === 'forbidden' ? 403 : 422;

                    return $responder->error($e->getMessage() === 'forbidden' ? 'forbidden' : 'validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), $status, $e->details());
                }

                return $responder->success($issued, 201);
            });

            $group->post('/keys/{keyId}/lifecycle', function ($request, $response, array $args) use ($container, $responder) {
                $body = (array) $request->getParsedBody();
                $state = (string) ($body['state'] ?? '');

                try {
                    $ok = $container->get(KeyLifecycleService::class)->transition((string) $args['keyId'], $state, (string) $request->getAttribute('request_id', 'unknown'));
                } catch (AuthException $e) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, $e->details());
                }

                if (!$ok) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->json(204, ['data' => null]);
            });

            $group->post('/posts/{postId}/moderation', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $body = (array) $request->getParsedBody();
                $action = trim((string) ($body['action'] ?? ''));
                $reasonCode = trim((string) ($body['reason_code'] ?? ''));

                if (!in_array($action, ['hide', 'lock', 'archive', 'delete'], true)) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'action', 'code' => 'unknown_value', 'message' => 'unsupported moderation action'],
                    ]);
                }

                $actorId = (string) ($principal['sub'] ?? 'owner_console');
                $result = $container->get(ModerationService::class)->moderatePost(
                    (string) $args['postId'],
                    $actorId,
                    $action,
                    $reasonCode !== '' ? $reasonCode : null,
                    (string) $request->getAttribute('request_id', 'unknown')
                );

                if ($result === null) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->success($result);
            });

            $group->post('/posts/{postId}/comments/{commentId}/moderation', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $body = (array) $request->getParsedBody();
                $action = trim((string) ($body['action'] ?? ''));
                $reasonCode = trim((string) ($body['reason_code'] ?? ''));

                if (!in_array($action, ['hide', 'lock', 'delete'], true)) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'action', 'code' => 'unknown_value', 'message' => 'unsupported moderation action'],
                    ]);
                }

                $actorId = (string) ($principal['sub'] ?? 'owner_console');
                $result = $container->get(ModerationService::class)->moderateComment(
                    (string) $args['postId'],
                    (string) $args['commentId'],
                    $actorId,
                    $action,
                    $reasonCode !== '' ? $reasonCode : null,
                    (string) $request->getAttribute('request_id', 'unknown')
                );

                if ($result === null) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->success($result);
            });
        });

        foreach ($surfaceMiddleware as $middleware) {
            $group->add($middleware);
        }
    }

    /** @param list<object> $surfaceMiddleware */
    private function registerGatewayRoutes(App $app, ContainerInterface $container, EnvelopeResponder $responder, array $surfaceMiddleware): void
    {
        $group = $app->group('/api', function ($group) use ($container, $responder) {
            $group->get('/feed', function ($request, $response) use ($container, $responder) {
                $query = $request->getQueryParams();
                $scope = (string) ($query['scope'] ?? 'delegated');
                $limit = (int) ($query['limit'] ?? 50);
                $cursor = (string) ($query['cursor'] ?? '');

                $result = $container->get(FeedService::class)->list($scope, max(1, min($limit, 200)), $cursor !== '' ? $cursor : null);

                return $responder->list($result['items'], $result['next_cursor'], $result['limit']);
            });

            $group->post('/posts', function ($request, $response) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                if (!$this->hasPermission($principal, 'posts:create') || (($principal['key_class'] ?? '') === 'use')) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'use_key_post_create_forbidden']);
                }

                $authorId = (string) ($principal['sub'] ?? 'gateway_key');
                $body = (array) $request->getParsedBody();
                $visibility = (string) ($body['visibility_scope'] ?? 'delegated');
                $title = trim((string) ($body['title'] ?? ''));
                $postBody = trim((string) ($body['body'] ?? ''));
                $state = (string) ($body['state'] ?? 'published');
                if (!in_array($visibility, ['public', 'private', 'delegated'], true)) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'visibility_scope', 'code' => 'unknown_value', 'message' => 'unsupported visibility scope'],
                    ]);
                }
                if ($title === '' || $postBody === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'title', 'code' => 'required', 'message' => 'is required'],
                        ['path' => 'body', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }

                $post = $container->get(PostsService::class)->create($authorId, $visibility, $title, $postBody, $state);

                return $responder->success($post, 201);
            });

            $group->patch('/posts/{postId}', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                if (!$this->hasPermission($principal, 'posts:edit')) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'posts_edit_forbidden']);
                }

                $body = (array) $request->getParsedBody();
                $title = trim((string) ($body['title'] ?? ''));
                $postBody = trim((string) ($body['body'] ?? ''));
                if ($title === '' || $postBody === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'title', 'code' => 'required', 'message' => 'is required'],
                        ['path' => 'body', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }

                $reason = trim((string) ($body['change_reason_code'] ?? 'manual_edit'));
                $revised = $container->get(PostsService::class)->revise(
                    (string) $args['postId'],
                    (string) ($principal['sub'] ?? 'gateway_key'),
                    $title,
                    $postBody,
                    $reason
                );

                if ($revised === null) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->success($revised);
            });

            $group->post('/posts/{postId}/flags', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $body = (array) $request->getParsedBody();
                $reason = trim((string) ($body['reason_code'] ?? ''));
                if ($reason === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'reason_code', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }
                $ok = $container->get(PostsService::class)->flag(
                    (string) $args['postId'],
                    (string) ($principal['sub'] ?? 'gateway_key'),
                    $reason
                );

                if (!$ok) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->success([
                    'post_id' => (string) $args['postId'],
                    'flagged' => true,
                    'reason_code' => $reason,
                ], 201);
            });

            $group->get('/posts/{postId}', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $post = $container->get(PostsService::class)->find((string) $args['postId']);
                if ($post === null || $post['state'] === 'deleted') {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                if (!$this->isVisibleToPrincipal($post, $principal)) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                if (!$this->hasPermission($principal, 'posts:read')) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'permission_mask_forbidden']);
                }

                return $responder->success($post);
            });

            $group->get('/posts/{postId}/comments', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $post = $container->get(PostsService::class)->find((string) $args['postId']);
                if ($post === null || !$this->isVisibleToPrincipal($post, $principal)) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                $comments = $container->get(CommentsService::class)->listForPost((string) $args['postId']);

                return $responder->list($comments, null, 50);
            });

            $group->post('/posts/{postId}/comments', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $body = (array) $request->getParsedBody();
                $post = $container->get(PostsService::class)->find((string) $args['postId']);
                if ($post === null || !$this->isVisibleToPrincipal($post, $principal)) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                if (in_array($post['state'], ['locked', 'archived', 'hidden', 'deleted'], true)) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'post_state_blocks_comment_create']);
                }

                if (!$this->hasPermission($principal, 'comments:create')) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'comments_permission_missing']);
                }

                if (!(bool) ($principal['comments_enabled'] ?? false)) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'comments_toggle_off']);
                }

                $commentBody = trim((string) ($body['body'] ?? ''));
                if ($commentBody === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'body', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }

                $comment = $container->get(CommentsService::class)->create(
                    (string) $args['postId'],
                    (string) ($principal['sub'] ?? 'gateway_key'),
                    $commentBody,
                    (string) $request->getAttribute('request_id', 'unknown'),
                );

                return $responder->success($comment, 201);
            });
        });

        foreach ($surfaceMiddleware as $middleware) {
            $group->add($middleware);
        }
    }

    /** @param array<string,mixed> $principal */
    private function hasPermission(array $principal, string $permission): bool
    {
        $permissions = $principal['permissions'] ?? [];
        if (!is_array($permissions)) {
            return false;
        }

        return in_array($permission, array_map('strval', $permissions), true);
    }

    /** @param array<string,string> $post
     *  @param array<string,mixed> $principal
     */
    private function isVisibleToPrincipal(array $post, array $principal): bool
    {
        if ($post['visibility_scope'] === 'public') {
            return true;
        }

        if (($principal['sub'] ?? '') === $post['author_id']) {
            return true;
        }

        if ($post['visibility_scope'] !== 'delegated') {
            return false;
        }

        $scope = $principal['scope'] ?? [];
        if (!is_array($scope)) {
            return false;
        }

        $scope = array_map('strval', $scope);

        return in_array('posts:all', $scope, true) || in_array('post:' . $post['id'], $scope, true);
    }
}
