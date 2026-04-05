<?php

declare(strict_types=1);

namespace Cre8\Application\Health;

use Cre8\Config\RuntimeConfig;
use Cre8\Security\KeyMaterial;
use GuzzleHttp\ClientInterface;
use PDO;
use Symfony\Component\RateLimiter\RateLimiterFactory;

final class HealthService
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly ClientInterface $httpClient,
        private readonly RateLimiterFactory $rateLimiterFactory,
        private readonly RuntimeConfig $config,
    ) {
    }

    /** @return array<string,mixed> */
    public function check(): array
    {
        $started = microtime(true);
        $failures = [];
        $db = ['status' => 'down'];
        try {
            $dbOk = (bool) $this->pdo->query('SELECT 1')->fetchColumn();
            $db = ['status' => $dbOk ? 'ok' : 'down'];
            if (!$dbOk) {
                $failures[] = 'db_probe_false';
            }
        } catch (\Throwable $e) {
            $db = ['status' => 'down', 'error' => $e::class];
            $failures[] = 'db_probe_exception';
        }

        $limiter = ['status' => 'down'];
        try {
            $accepted = $this->rateLimiterFactory->create('healthcheck')->consume(1)->isAccepted();
            $limiter = ['status' => $accepted ? 'ok' : 'degraded'];
            if (!$accepted) {
                $failures[] = 'rate_limiter_rejected';
            }
        } catch (\Throwable $e) {
            $limiter = ['status' => 'down', 'error' => $e::class];
            $failures[] = 'rate_limiter_exception';
        }

        $keyMaterial = ['status' => 'down'];
        try {
            KeyMaterial::resolve($this->config->jwtPrivateKey);
            KeyMaterial::resolve($this->config->jwtPublicKey);
            $keyMaterial = ['status' => 'ok'];
        } catch (\Throwable $e) {
            $keyMaterial = ['status' => 'down', 'error' => $e::class];
            $failures[] = 'key_material_unavailable';
        }

        $httpDependency = ['status' => 'down'];
        try {
            $response = $this->httpClient->request('HEAD', $this->config->jwtIssuer, ['timeout' => 2.0]);
            $statusCode = $response->getStatusCode();
            $httpDependency = [
                'status' => $statusCode >= 200 && $statusCode < 500 ? 'ok' : 'degraded',
                'status_code' => $statusCode,
            ];
            if ($statusCode >= 500) {
                $failures[] = 'http_dependency_5xx';
            }
        } catch (\Throwable $e) {
            $httpDependency = ['status' => 'down', 'error' => $e::class];
            $failures[] = 'http_dependency_exception';
        }

        $status = $failures === [] ? 'ok' : 'degraded';

        return [
            'status' => $status,
            'checked_at_utc' => gmdate('c'),
            'latency_ms' => (int) round((microtime(true) - $started) * 1000),
            'failures' => $failures,
            'services' => [
                'db' => $db,
                'rate_limiter' => $limiter,
                'key_material' => $keyMaterial,
                'http_dependency' => $httpDependency,
                'http_client_class' => $this->httpClient::class,
            ],
        ];
    }
}
