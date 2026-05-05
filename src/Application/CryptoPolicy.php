<?php

declare(strict_types=1);

namespace Cre8\Application;

final class CryptoPolicy
{
    /** @var array<string,int> */
    private static array $replayCache = [];
    public const ARGON2ID_MIN_MEMORY_COST = 65536;
    public const ARGON2ID_MIN_TIME_COST = 3;
    public const ARGON2ID_MIN_THREADS = 1;
    public const NONCE_MIN_BYTES = 24;
    public const CLOCK_SKEW_SECONDS = 120;
    public const REPLAY_RETENTION_SECONDS = 900;

    public static function validateProof(array $request): ?string
    {
        foreach (['public_key_id', 'timestamp', 'nonce', 'signature'] as $field) {
            if (!is_string($request[$field] ?? null) || $request[$field] === '') {
                return 'AUTHN_PROOF_INVALID';
            }
        }

        $nonce = (string) $request['nonce'];
        if (strlen($nonce) < self::NONCE_MIN_BYTES) {
            return 'AUTHN_PROOF_INVALID_NONCE';
        }

        $ts = strtotime((string) $request['timestamp']);
        if ($ts === false || abs(time() - $ts) > self::CLOCK_SKEW_SECONDS) {
            return 'AUTHN_PROOF_INVALID_TIMESTAMP';
        }

        $replayTuple = implode('|', [(string) $request['public_key_id'], (string) $request['timestamp'], $nonce, (string) $request['signature']]);
        $now = time();
        foreach (self::$replayCache as $tuple => $seenAt) {
            if (($now - $seenAt) > self::REPLAY_RETENTION_SECONDS) {
                unset(self::$replayCache[$tuple]);
            }
        }
        if (isset(self::$replayCache[$replayTuple])) {
            return 'AUTHN_PROOF_REPLAY_DETECTED';
        }
        self::$replayCache[$replayTuple] = $now;

        return null;
    }

    public static function isArgon2idProfileCompliant(array $options): bool
    {
        return ($options['memory_cost'] ?? 0) >= self::ARGON2ID_MIN_MEMORY_COST
            && ($options['time_cost'] ?? 0) >= self::ARGON2ID_MIN_TIME_COST
            && ($options['threads'] ?? 0) >= self::ARGON2ID_MIN_THREADS;
    }
}
