<?php

declare(strict_types=1);

$baseUrl = (string) ($_ENV['CRE8_HEALTHCHECK_URL'] ?? $_SERVER['CRE8_HEALTHCHECK_URL'] ?? 'http://127.0.0.1:8080');
$baseUrl = rtrim($baseUrl, '/');
$url = $baseUrl . '/health';

if (!function_exists('curl_init')) {
    fwrite(STDERR, "health_smoke_failed:curl_extension_missing\n");
    exit(2);
}

$ch = curl_init($url);
if ($ch === false) {
    fwrite(STDERR, "health_smoke_failed:curl_init\n");
    exit(2);
}

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => ['Accept: application/json'],
]);

$body = curl_exec($ch);
$error = curl_error($ch);
$statusCode = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

if (!is_string($body)) {
    fwrite(STDERR, "health_smoke_failed:http_error:" . $error . "\n");
    exit(3);
}

if ($statusCode !== 200) {
    fwrite(STDERR, "health_smoke_failed:unexpected_status:$statusCode\n");
    exit(4);
}

$decoded = json_decode($body, true);
if (!is_array($decoded)) {
    fwrite(STDERR, "health_smoke_failed:invalid_json\n");
    exit(5);
}

$data = $decoded['data'] ?? null;
if (!is_array($data)) {
    fwrite(STDERR, "health_smoke_failed:missing_data_envelope\n");
    exit(6);
}

$status = (string) ($data['status'] ?? '');
if (!in_array($status, ['ok', 'degraded'], true)) {
    fwrite(STDERR, "health_smoke_failed:invalid_status:$status\n");
    exit(7);
}

echo "health_smoke_ok:$status\n";
