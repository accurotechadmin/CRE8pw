<?php

declare(strict_types=1);

namespace Cre8\Application;

final class KeyLifecycleLedger
{
    /** @var array<string,string> */
    private array $states = [];

    /** @var list<array<string,mixed>> */
    private array $events = [];

    public function issue(string $keyId, string $actorId): void
    {
        $this->transition($keyId, 'issued', $actorId, 'issued');
        $this->transition($keyId, 'issued', $actorId, 'active');
    }

    public function suspend(string $keyId, string $actorId): void
    {
        $this->transition($keyId, $this->stateOf($keyId), $actorId, 'suspended');
    }

    public function revoke(string $keyId, string $actorId): void
    {
        $this->transition($keyId, $this->stateOf($keyId), $actorId, 'revoked');
    }

    public function rotate(string $oldKeyId, string $newKeyId, string $actorId): void
    {
        $this->transition($oldKeyId, $this->stateOf($oldKeyId), $actorId, 'rotated');
        $this->transition($newKeyId, 'issued', $actorId, 'active');
    }

    public function stateOf(string $keyId): string
    {
        return $this->states[$keyId] ?? 'issued';
    }

    /** @return list<array<string,mixed>> */
    public function events(): array
    {
        return $this->events;
    }

    private function transition(string $keyId, string $from, string $actorId, string $to): void
    {
        $this->states[$keyId] = $to;
        $this->events[] = [
            'key_id' => $keyId,
            'actor_id' => $actorId,
            'prior_state' => $from,
            'next_state' => $to,
            'timestamp_utc' => gmdate('Y-m-d\TH:i:s\Z'),
        ];
    }
}
