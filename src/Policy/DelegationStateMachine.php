<?php

declare(strict_types=1);

namespace Cre8\Policy;

final class DelegationStateMachine
{
    /** @var array<string,array<string,array{to:string,deny:string}>> */
    private const MAP = [
        'proposed' => ['grant' => ['to' => 'granted', 'deny' => 'AUTH_LIFECYCLE_BLOCKED']],
        'granted' => ['accept' => ['to' => 'active', 'deny' => 'AUTH_CREDENTIAL_INVALID']],
        'active' => [
            'suspend' => ['to' => 'suspended', 'deny' => 'AUTH_PERMISSION_DENIED'],
            'revoke' => ['to' => 'revoked', 'deny' => 'AUTH_PERMISSION_DENIED'],
            'rotate' => ['to' => 'rotated', 'deny' => 'AUTH_LIFECYCLE_BLOCKED'],
            'expire' => ['to' => 'expired', 'deny' => 'AUTH_GRANT_EXPIRED'],
        ],
        'suspended' => [
            'resume' => ['to' => 'active', 'deny' => 'AUTH_LIFECYCLE_BLOCKED'],
            'revoke' => ['to' => 'revoked', 'deny' => 'AUTH_PERMISSION_DENIED'],
            'rotate' => ['to' => 'rotated', 'deny' => 'AUTH_LIFECYCLE_BLOCKED'],
            'expire' => ['to' => 'expired', 'deny' => 'AUTH_GRANT_EXPIRED'],
        ],
        'rotated' => ['expire' => ['to' => 'expired', 'deny' => 'AUTH_GRANT_EXPIRED']],
        'revoked' => ['retire' => ['to' => 'retired', 'deny' => 'AUTH_LIFECYCLE_BLOCKED']],
        'expired' => ['retire' => ['to' => 'retired', 'deny' => 'AUTH_LIFECYCLE_BLOCKED']],
    ];

    /** @param array<string,mixed> $ctx */
    public function transition(string $fromState, string $event, array $ctx = []): array
    {
        if (!isset(self::MAP[$fromState][$event])) {
            return ['outcome' => 'DENY_TRANSITION', 'reason_code' => 'AUTH_LIFECYCLE_BLOCKED', 'failure_gate' => 'from_state_validity', 'from_state' => $fromState, 'requested_event' => $event];
        }

        if (($ctx['actor_authorized'] ?? true) !== true) {
            return ['outcome' => 'DENY_TRANSITION', 'reason_code' => self::MAP[$fromState][$event]['deny'], 'failure_gate' => 'actor_authority', 'from_state' => $fromState, 'requested_event' => $event];
        }

        if (($ctx['lifecycle_guard_ok'] ?? true) !== true) {
            return ['outcome' => 'DENY_TRANSITION', 'reason_code' => self::MAP[$fromState][$event]['deny'], 'failure_gate' => 'lifecycle_guard', 'from_state' => $fromState, 'requested_event' => $event];
        }

        if (($ctx['time_guard_ok'] ?? true) !== true) {
            return ['outcome' => 'DENY_TRANSITION', 'reason_code' => self::MAP[$fromState][$event]['deny'], 'failure_gate' => 'expiry_time_guard', 'from_state' => $fromState, 'requested_event' => $event];
        }

        return ['outcome' => 'ALLOW_TRANSITION', 'to_state' => self::MAP[$fromState][$event]['to'], 'from_state' => $fromState, 'requested_event' => $event];
    }
}
