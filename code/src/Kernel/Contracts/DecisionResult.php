<?php

declare(strict_types=1);

namespace Cre8\Kernel\Contracts;

/**
 * TODO(owner: platform-core): Implement DecisionResult.
 * Purpose: Standard policy decision object: allow/deny + reason + violations.
 * Acceptance criteria:
 * - [ ] Behavior aligns with /docs/SSOT contracts and policies.
 * - [ ] Contains no fake business logic.
 * - [ ] Covered by tests when implemented.
 */
final readonly class DecisionResult
{
    public function __construct(
        public bool $allowed = false,
        public ?string $reason = null,
        /** @var list<string> */
        public array $violations = [],
    ) {
    }
}
