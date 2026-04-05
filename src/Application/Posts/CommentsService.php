<?php

declare(strict_types=1);

namespace Cre8\Application\Posts;

use Cre8\Observability\AuditEmitter;
use PDO;

final class CommentsService
{
    public function __construct(private readonly PDO $pdo, private readonly AuditEmitter $auditEmitter)
    {
        $this->ensureStorageReady();
    }

    /** @return list<array{id:string,post_id:string,author_id:string,body:string,state:string,created_at_utc:string}> */
    public function listForPost(string $postId): array
    {
        $stmt = $this->pdo->prepare('SELECT id, post_id, author_principal_id, body_text, state, created_at FROM comments WHERE post_id = :post AND state != :deleted ORDER BY created_at ASC, id ASC');
        $stmt->execute(['post' => $postId, 'deleted' => 'deleted']);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return array_map(static function (array $row): array {
            $createdAtRaw = (string) $row['created_at'];
            $createdAt = strtotime($createdAtRaw);

            return [
                'id' => (string) $row['id'],
                'post_id' => (string) $row['post_id'],
                'author_id' => (string) $row['author_principal_id'],
                'body' => (string) $row['body_text'],
                'state' => (string) $row['state'],
                'created_at_utc' => $createdAt === false ? $createdAtRaw : gmdate('c', $createdAt),
            ];
        }, $rows);
    }

    /** @return array{id:string,post_id:string,author_id:string,body:string,state:string,created_at_utc:string} */
    public function create(string $postId, string $authorId, string $body, string $requestId): array
    {
        $id = bin2hex(random_bytes(16));
        $createdAt = $this->dbTimestamp();
        $normalizedBody = trim($body);

        $stmt = $this->pdo->prepare('INSERT INTO comments (id, post_id, author_principal_id, body_text, state, created_at) VALUES (:id, :post_id, :author_id, :body_text, :state, :created_at)');
        $stmt->execute([
            'id' => $id,
            'post_id' => $postId,
            'author_id' => $authorId,
            'body_text' => $normalizedBody,
            'state' => 'active',
            'created_at' => $createdAt,
        ]);

        $this->auditEmitter->emit('comments.created', [
            'request_id' => $requestId,
            'principal_id' => $authorId,
            'post_id' => $postId,
            'comment_id' => $id,
            'decision' => 'allow',
            'decision_reason_code' => 'comment_created',
        ]);

        return [
            'id' => $id,
            'post_id' => $postId,
            'author_id' => $authorId,
            'body' => $normalizedBody,
            'state' => 'active',
            'created_at_utc' => gmdate('c', strtotime($createdAt) ?: time()),
        ];
    }

    private function ensureStorageReady(): void
    {
        if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            return;
        }

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS comments (
            id CHAR(32) PRIMARY KEY,
            post_id CHAR(32) NOT NULL,
            author_principal_id CHAR(32) NOT NULL,
            body_text TEXT NOT NULL,
            state TEXT NOT NULL,
            created_at TEXT NOT NULL,
            deleted_at TEXT NULL,
            deleted_by CHAR(32) NULL,
            delete_reason_code TEXT NULL
        )');
    }

    private function dbTimestamp(?int $unixTime = null): string
    {
        return gmdate('Y-m-d H:i:s', $unixTime ?? time());
    }
}
