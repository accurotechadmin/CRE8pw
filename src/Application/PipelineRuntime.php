<?php

declare(strict_types=1);

namespace Cre8\Application;

use Cre8\Policy\PolicyDecisionPointInterface;

final class PipelineRuntime
{
    public function __construct(private readonly PolicyDecisionPointInterface $pdp) {}

    /** @param array<string,mixed> $request */
    public function handleProtected(array $request): array
    {
        $requestId = is_string($request['request_id'] ?? null) && $request['request_id'] !== ''
            ? $request['request_id']
            : 'req-' . bin2hex(random_bytes(8));

        $proofValidationError = CryptoPolicy::validateProof($request);
        if ($proofValidationError !== null) {
            return $this->errorEnvelope($proofValidationError, $requestId);
        }

        $decision = $this->pdp->decide($request);
        if (($decision['outcome'] ?? RuntimeTerms::deny()) !== RuntimeTerms::allow()) {
            return $this->errorEnvelope((string)($decision['reason_code'] ?? 'AUTH_DENY_DEFAULT'), $requestId);
        }

        return [
            'data' => ['accepted' => true],
            'meta' => ['request_id' => $requestId],
        ];
    }

    private function errorEnvelope(string $code, string $requestId): array
    {
        return ['error' => ['code' => $code], 'meta' => ['request_id' => $requestId]];
    }
}
