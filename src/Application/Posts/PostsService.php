<?php

declare(strict_types=1);

namespace Cre8\Application\Posts;

use PDO;

final class PostsService
{
    public function __construct(private readonly PDO $pdo)
    {
        $this->ensureStorageReady();
    }

    /**
     * @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}>
     */
    public function listForAuthor(string $authorId): array
    {
        $stmt = $this->pdo->prepare('SELECT id, author_principal_id, visibility_scope, state, title_text, body_text, created_at FROM posts WHERE author_principal_id = :author ORDER BY created_at DESC, id DESC');
        $stmt->execute(['author' => $authorId]);

        return $this->mapRows($stmt->fetchAll(PDO::FETCH_ASSOC) ?: []);
    }

    /**
     * @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}>
     */
    public function listVisible(string $scope): array
    {
        return match ($scope) {
            'public' => $this->fetchByVisibility(['public']),
            'delegated' => $this->fetchByVisibility(['public', 'delegated']),
            default => $this->fetchAll(),
        };
    }

    /** @return array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string} */
    public function create(string $authorId, string $visibilityScope, string $title, string $body, string $state = 'published'): array
    {
        $id = bin2hex(random_bytes(16));
        $createdAt = $this->dbTimestamp();
        $normalizedState = in_array($state, ['draft', 'published'], true) ? $state : 'published';

        $stmt = $this->pdo->prepare('INSERT INTO posts (id, author_principal_id, visibility_scope, state, title_text, body_text, created_at) VALUES (:id, :author, :scope, :state, :title, :body, :created_at)');
        $stmt->execute([
            'id' => $id,
            'author' => $authorId,
            'scope' => $visibilityScope,
            'state' => $normalizedState,
            'title' => trim($title),
            'body' => trim($body),
            'created_at' => $createdAt,
        ]);

        return [
            'id' => $id,
            'author_id' => $authorId,
            'visibility_scope' => $visibilityScope,
            'state' => $normalizedState,
            'title' => trim($title),
            'body' => trim($body),
            'created_at_utc' => gmdate('c', strtotime($createdAt) ?: time()),
        ];
    }

    /** @return array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}|null */
    public function find(string $postId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, author_principal_id, visibility_scope, state, title_text, body_text, created_at FROM posts WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $postId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!is_array($row)) {
            return null;
        }

        return $this->mapRow($row);
    }

    /** @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}> */
    private function fetchByVisibility(array $scopes): array
    {
        $placeholders = implode(',', array_fill(0, count($scopes), '?'));
        $stmt = $this->pdo->prepare("SELECT id, author_principal_id, visibility_scope, state, title_text, body_text, created_at FROM posts WHERE state != 'deleted' AND visibility_scope IN ($placeholders) ORDER BY created_at DESC, id DESC");
        $stmt->execute($scopes);

        return $this->mapRows($stmt->fetchAll(PDO::FETCH_ASSOC) ?: []);
    }

    /** @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}> */
    private function fetchAll(): array
    {
        $stmt = $this->pdo->query("SELECT id, author_principal_id, visibility_scope, state, title_text, body_text, created_at FROM posts WHERE state != 'deleted' ORDER BY created_at DESC, id DESC");

        return $this->mapRows($stmt->fetchAll(PDO::FETCH_ASSOC) ?: []);
    }

    /** @param list<array<string,mixed>> $rows
     *  @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}>
     */
    private function mapRows(array $rows): array
    {
        return array_map(fn (array $row): array => $this->mapRow($row), $rows);
    }

    /** @param array<string,mixed> $row
     * @return array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}
     */
    private function mapRow(array $row): array
    {
        $createdAtRaw = (string) $row['created_at'];
        $createdAt = strtotime($createdAtRaw);

        return [
            'id' => (string) $row['id'],
            'author_id' => (string) $row['author_principal_id'],
            'visibility_scope' => (string) $row['visibility_scope'],
            'state' => (string) $row['state'],
            'title' => (string) ($row['title_text'] ?? ''),
            'body' => (string) ($row['body_text'] ?? ''),
            'created_at_utc' => $createdAt === false ? $createdAtRaw : gmdate('c', $createdAt),
        ];
    }

    /** @return array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}|null */
    public function revise(string $postId, string $editorId, string $title, string $body, string $reasonCode): ?array
    {
        $existing = $this->find($postId);
        if ($existing === null) {
            return null;
        }

        $editedAt = $this->dbTimestamp();
        $revisionId = bin2hex(random_bytes(16));
        $this->pdo->beginTransaction();
        try {
            $this->pdo->prepare('UPDATE posts SET title_text = :title, body_text = :body WHERE id = :id')
                ->execute(['title' => trim($title), 'body' => trim($body), 'id' => $postId]);

            $this->pdo->prepare('INSERT INTO post_revisions (id, post_id, editor_principal_id, title_text, body_text, change_reason_code, edited_at) VALUES (:id, :post_id, :editor, :title, :body, :reason, :edited_at)')
                ->execute([
                    'id' => $revisionId,
                    'post_id' => $postId,
                    'editor' => $editorId,
                    'title' => trim($title),
                    'body' => trim($body),
                    'reason' => $reasonCode,
                    'edited_at' => $editedAt,
                ]);
            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        return $this->find($postId);
    }

    public function flag(string $postId, string $actorId, string $reasonCode): bool
    {
        $existing = $this->find($postId);
        if ($existing === null) {
            return false;
        }

        $this->pdo->prepare('INSERT INTO post_flags (id, post_id, actor_principal_id, reason_code, created_at) VALUES (:id, :post_id, :actor, :reason, :created_at)')
            ->execute([
                'id' => bin2hex(random_bytes(16)),
                'post_id' => $postId,
                'actor' => $actorId,
                'reason' => $reasonCode,
                'created_at' => $this->dbTimestamp(),
            ]);

        return true;
    }

    private function ensureStorageReady(): void
    {
        if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            return;
        }

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS posts (
            id CHAR(32) PRIMARY KEY,
            author_principal_id CHAR(32) NOT NULL,
            visibility_scope TEXT NOT NULL,
            state TEXT NOT NULL,
            title_text TEXT NOT NULL DEFAULT \'\',
            body_text TEXT NOT NULL DEFAULT \'\',
            created_at TEXT NOT NULL,
            deleted_at TEXT NULL,
            deleted_by CHAR(32) NULL,
            delete_reason_code TEXT NULL
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS post_revisions (
            id CHAR(32) PRIMARY KEY,
            post_id CHAR(32) NOT NULL,
            editor_principal_id CHAR(32) NOT NULL,
            title_text TEXT NOT NULL,
            body_text TEXT NOT NULL,
            change_reason_code TEXT NOT NULL,
            edited_at TEXT NOT NULL
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS post_flags (
            id CHAR(32) PRIMARY KEY,
            post_id CHAR(32) NOT NULL,
            actor_principal_id CHAR(32) NOT NULL,
            reason_code TEXT NOT NULL,
            created_at TEXT NOT NULL
        )');
    }

    private function dbTimestamp(?int $unixTime = null): string
    {
        return gmdate('Y-m-d H:i:s', $unixTime ?? time());
    }
}
