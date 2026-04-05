<?php

declare(strict_types=1);

namespace Cre8\Application\Posts;

use Cre8\Observability\AuditEmitter;
use PDO;

final class ModerationService
{
    public function __construct(private readonly PDO $pdo, private readonly AuditEmitter $auditEmitter)
    {
        $this->ensureStorageReady();
    }

    /** @return array{id:string,state:string,action:string,reason_code:?string,moderated_at_utc:string}|null */
    public function moderatePost(string $postId, string $actorId, string $action, ?string $reasonCode, string $requestId): ?array
    {
        $nextState = match ($action) {
            'hide' => 'hidden',
            'lock' => 'locked',
            'archive' => 'archived',
            'delete' => 'deleted',
            default => null,
        };

        if ($nextState === null) {
            return null;
        }

        $now = $this->dbTimestamp();
        $stmt = $this->pdo->prepare('SELECT id FROM posts WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $postId]);
        if (!is_array($stmt->fetch(PDO::FETCH_ASSOC))) {
            return null;
        }

        $this->pdo->beginTransaction();
        try {
            $this->pdo->prepare('UPDATE posts SET state = :state, deleted_at = :deleted_at, deleted_by = :deleted_by, delete_reason_code = :reason WHERE id = :id')
                ->execute([
                    'state' => $nextState,
                    'deleted_at' => $nextState === 'deleted' ? $now : null,
                    'deleted_by' => $nextState === 'deleted' ? $actorId : null,
                    'reason' => $nextState === 'deleted' ? $reasonCode : null,
                    'id' => $postId,
                ]);

            $this->recordModerationAction($actorId, $action, $reasonCode, $now, $postId, null);
            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        $this->auditEmitter->emit('moderation.post_' . $action, [
            'request_id' => $requestId,
            'principal_id' => $actorId,
            'resource_type' => 'post',
            'resource_id' => $postId,
            'action' => 'moderate:' . $action,
            'decision' => 'allow',
            'decision_reason_code' => 'post_' . $action,
        ]);

        return [
            'id' => $postId,
            'state' => $nextState,
            'action' => $action,
            'reason_code' => $reasonCode,
            'moderated_at_utc' => gmdate('c', strtotime($now) ?: time()),
        ];
    }

    /** @return array{id:string,state:string,action:string,reason_code:?string,moderated_at_utc:string}|null */
    public function moderateComment(string $commentId, string $actorId, string $action, ?string $reasonCode, string $requestId): ?array
    {
        $nextState = match ($action) {
            'hide' => 'hidden',
            'lock' => 'locked',
            'delete' => 'deleted',
            default => null,
        };

        if ($nextState === null) {
            return null;
        }

        $now = $this->dbTimestamp();
        $stmt = $this->pdo->prepare('SELECT id, post_id FROM comments WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $commentId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!is_array($row)) {
            return null;
        }

        $this->pdo->beginTransaction();
        try {
            $this->pdo->prepare('UPDATE comments SET state = :state, deleted_at = :deleted_at, deleted_by = :deleted_by, delete_reason_code = :reason WHERE id = :id')
                ->execute([
                    'state' => $nextState,
                    'deleted_at' => $nextState === 'deleted' ? $now : null,
                    'deleted_by' => $nextState === 'deleted' ? $actorId : null,
                    'reason' => $nextState === 'deleted' ? $reasonCode : null,
                    'id' => $commentId,
                ]);

            $this->recordModerationAction($actorId, $action, $reasonCode, $now, null, (string) $row['id']);
            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        $this->auditEmitter->emit('moderation.comment_' . $action, [
            'request_id' => $requestId,
            'principal_id' => $actorId,
            'resource_type' => 'comment',
            'resource_id' => $commentId,
            'action' => 'moderate:' . $action,
            'decision' => 'allow',
            'decision_reason_code' => 'comment_' . $action,
        ]);

        return [
            'id' => $commentId,
            'state' => $nextState,
            'action' => $action,
            'reason_code' => $reasonCode,
            'moderated_at_utc' => gmdate('c', strtotime($now) ?: time()),
        ];
    }

    private function recordModerationAction(string $actorId, string $action, ?string $reasonCode, string $createdAt, ?string $postId, ?string $commentId): void
    {
        $this->pdo->prepare('INSERT INTO moderation_actions (id, post_id, comment_id, actor_principal_id, action, reason_code, created_at) VALUES (:id, :post_id, :comment_id, :actor, :action, :reason, :created_at)')
            ->execute([
                'id' => bin2hex(random_bytes(16)),
                'post_id' => $postId,
                'comment_id' => $commentId,
                'actor' => $actorId,
                'action' => $action,
                'reason' => $reasonCode,
                'created_at' => $createdAt,
            ]);
    }

    private function ensureStorageReady(): void
    {
        if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            return;
        }

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS moderation_actions (
            id CHAR(32) PRIMARY KEY,
            post_id CHAR(32) NULL,
            comment_id CHAR(32) NULL,
            actor_principal_id CHAR(32) NOT NULL,
            action TEXT NOT NULL,
            reason_code TEXT NULL,
            created_at TEXT NOT NULL
        )');
    }

    private function dbTimestamp(?int $unixTime = null): string
    {
        return gmdate('Y-m-d H:i:s', $unixTime ?? time());
    }
}
