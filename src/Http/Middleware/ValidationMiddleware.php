<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Validator as v;

final class ValidationMiddleware implements MiddlewareInterface
{
    /** @var array<string, array{required:list<string>, allowed:list<string>}> */
    private array $schemas = [
        'POST /api/auth/login' => ['required' => ['email', 'password'], 'allowed' => ['email', 'password']],
        'POST /api/auth/refresh' => ['required' => ['refresh_token'], 'allowed' => ['refresh_token']],
        'POST /api/posts' => ['required' => ['title', 'body', 'visibility_scope'], 'allowed' => ['title', 'body', 'visibility_scope', 'state']],
        'PATCH /api/posts/{postId}' => ['required' => ['title', 'body'], 'allowed' => ['title', 'body', 'change_reason_code']],
        'POST /api/posts/{postId}/flags' => ['required' => ['reason_code'], 'allowed' => ['reason_code']],
        'POST /console/api/posts' => ['required' => ['title', 'body', 'visibility_scope'], 'allowed' => ['title', 'body', 'visibility_scope', 'state']],
        'POST /console/api/keys' => ['required' => ['key_class', 'permissions', 'scope'], 'allowed' => ['key_class', 'parent_envelope_id', 'permissions', 'scope', 'ttl_seconds', 'comments_enabled']],
    ];

    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $normalizedPath = preg_replace('#/[a-f0-9]{32}(?=/|$)#', '/{postId}', $path);
        $key = sprintf('%s %s', strtoupper($request->getMethod()), $normalizedPath);
        $schema = $this->schemas[$key] ?? null;
        if ($schema === null) {
            return $handler->handle($request);
        }

        $body = $request->getParsedBody();
        if (!is_array($body)) {
            $raw = '';
            try {
                $stream = $request->getBody();
                $offset = null;
                if ($stream->isSeekable()) {
                    $offset = $stream->tell();
                }

                $raw = (string) $stream;

                if ($offset !== null && $stream->isSeekable()) {
                    $stream->seek($offset);
                }
            } catch (\Throwable) {
                $raw = '';
            }

            if ($raw !== '') {
                try {
                    $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
                    if (is_array($decoded)) {
                        $body = $decoded;
                        $request = $request->withParsedBody($decoded);
                    }
                } catch (\Throwable) {
                    // JsonBodyMiddleware will return the canonical malformed JSON response.
                }
            }
        }

        if (!is_array($body)) {
            return $this->validationError($request, $key, [[
                'path' => 'body',
                'code' => 'invalid_type',
                'message' => 'must be an object',
                'detail_code' => 'validation_body_not_object',
            ]]);
        }

        $details = [];
        foreach (array_keys($body) as $field) {
            if (!in_array((string) $field, $schema['allowed'], true)) {
                $details[] = ['path' => (string) $field, 'code' => 'unknown_field', 'message' => 'field is not allowed'];
            }
        }

        foreach ($schema['required'] as $required) {
            if (!array_key_exists($required, $body) || $body[$required] === '' || $body[$required] === null) {
                $details[] = ['path' => $required, 'code' => 'required', 'message' => 'field is required'];
            }
        }

        if (isset($body['email']) && !is_string($body['email'])) {
            $details[] = ['path' => 'email', 'code' => 'invalid_type', 'message' => 'must be a string'];
        }

        if (isset($body['email']) && !v::email()->validate((string) $body['email'])) {
            $details[] = ['path' => 'email', 'code' => 'invalid_format', 'message' => 'must be a valid email'];
        }

        if (isset($body['visibility_scope']) && !v::in(['public', 'private', 'delegated'])->validate($body['visibility_scope'])) {
            $details[] = ['path' => 'visibility_scope', 'code' => 'unknown_value', 'message' => 'unsupported visibility scope'];
        }

        if (isset($body['state']) && !v::in(['draft', 'published'])->validate($body['state'])) {
            $details[] = ['path' => 'state', 'code' => 'unknown_value', 'message' => 'unsupported post state'];
        }

        if (isset($body['key_class']) && !v::in(['primary_author', 'secondary_author', 'use'])->validate($body['key_class'])) {
            $details[] = ['path' => 'key_class', 'code' => 'unknown_value', 'message' => 'unsupported key class'];
        }

        if (isset($body['permissions']) && !is_array($body['permissions'])) {
            $details[] = ['path' => 'permissions', 'code' => 'invalid_type', 'message' => 'must be an array'];
        }

        if (isset($body['scope']) && !is_array($body['scope'])) {
            $details[] = ['path' => 'scope', 'code' => 'invalid_type', 'message' => 'must be an array'];
        }

        if (isset($body['owner_id']) && !v::regex('/^[a-f0-9]{32}$/')->validate((string) $body['owner_id'])) {
            $details[] = ['path' => 'owner_id', 'code' => 'invalid_id_format', 'message' => 'must be lowercase hex32'];
        }

        foreach ($details as $index => $detail) {
            if (!isset($detail['detail_code'])) {
                $details[$index]['detail_code'] = 'validation_' . $detail['code'];
            }
        }

        if ($details !== []) {
            return $this->validationError($request, $key, $details);
        }

        $this->auditEmitter?->emit('validation.accepted', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'route_key' => $key,
            'outcome' => 'allow',
        ]);

        return $handler->handle($request);
    }

    /** @param list<array{path:string,code:string,message:string,detail_code:string}> $details */
    private function validationError(ServerRequestInterface $request, string $routeKey, array $details): ResponseInterface
    {
        $this->auditEmitter?->emit('validation.rejected', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'route_key' => $routeKey,
            'outcome' => 'deny',
            'reason_code' => 'validation_failed',
            'violation_count' => count($details),
        ]);

        return $this->responder->error('validation_failed', 'input validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, $details);
    }
}
