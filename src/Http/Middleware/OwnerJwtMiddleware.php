<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Config\RuntimeConfig;
use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\TokenValidationException;
use Cre8\Security\TokenVerifier;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class OwnerJwtMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly TokenVerifier $tokenVerifier,
        private readonly RuntimeConfig $config,
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $this->extractBearer($request);
        if ($token === null) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'bearer_missing',
            ]);

            return $this->responder->error('auth_required', 'authentication required', $requestId, 401, [
                'detail_code' => 'bearer_missing',
            ]);
        }

        try {
            $verification = $this->tokenVerifier->verify($token);
        } catch (TokenValidationException) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_verification_failed',
            ]);

            return $this->responder->error('auth_invalid', 'invalid token', $requestId, 401, [
                'detail_code' => 'token_verification_failed',
            ]);
        } catch (\Throwable) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.unavailable', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_dependency_unavailable',
            ]);

            return $this->responder->error('service_unavailable', 'authentication subsystem unavailable', $requestId, 503, [
                'detail_code' => 'token_dependency_unavailable',
            ]);
        }

        $tokenType = $verification->principal->type;
        $audience = $verification->principal->audience;
        if ($tokenType !== 'owner') {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_type_invalid',
            ]);

            return $this->responder->error('auth_invalid', 'invalid token type', $requestId, 401, [
                'detail_code' => 'token_type_invalid',
            ]);
        }

        if ($audience !== $this->config->jwtAudienceConsole) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_audience_invalid',
            ]);

            return $this->responder->error('auth_invalid', 'invalid token audience', $requestId, 401, [
                'detail_code' => 'token_audience_invalid',
            ]);
        }

        $requestId = (string) $request->getAttribute('request_id', 'unknown');
        $this->auditEmitter?->emit('auth.owner_jwt.validated', [
            'request_id' => $requestId,
            'path' => $request->getUri()->getPath(),
            'principal_id' => $verification->principal->id,
        ]);

        if ($verification->policyViolations !== []) {
            return $this->responder->error('auth_invalid', 'token policy violation', $requestId, 401, [
                'detail_code' => 'token_policy_violation',
                'violations' => $verification->policyViolations,
            ]);
        }

        return $handler->handle($request->withAttribute('principal', $verification->claims));
    }

    private function extractBearer(ServerRequestInterface $request): ?string
    {
        $header = $request->getHeaderLine('Authorization');
        if (!str_starts_with($header, 'Bearer ')) {
            return null;
        }

        $token = trim(substr($header, 7));
        if ($token === '') {
            return null;
        }

        return $token;
    }
}
