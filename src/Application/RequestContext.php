<?php

declare(strict_types=1);

namespace Cre8\Application;

final class RequestContext
{
    public function __construct(
        public readonly string $requestId,
        public readonly bool $authenticated,
        /** @var array{outcome:'Allow'|'Deny',reason_code?:string}|null */
        public readonly ?array $policyDecision = null,
    ) {}
}
