<?php

declare(strict_types=1);

namespace Cre8\Application\Feed;

use Cre8\Application\Posts\PostsService;

final class FeedService
{
    public function __construct(private readonly PostsService $postsService)
    {
    }

    /** @return array{items:list<array<string,string>>,next_cursor:?string,limit:int} */
    public function list(string $scope, int $limit, ?string $cursor): array
    {
        $items = $this->postsService->listVisible($scope);
        $sliceStart = $this->resolveStartIndex($items, $cursor);
        $seen = [];
        $slice = [];
        for ($i = $sliceStart; $i < count($items) && count($slice) < $limit; $i++) {
            $id = (string) ($items[$i]['id'] ?? '');
            if ($id === '' || isset($seen[$id])) {
                continue;
            }
            $seen[$id] = true;
            $slice[] = $items[$i];
        }

        $last = $slice[count($slice) - 1] ?? null;
        $nextCursor = null;
        if ($last !== null && ($sliceStart + count($slice)) < count($items)) {
            $nextCursor = $this->encodeCursor((string) $last['created_at_utc'], (string) $last['id']);
        }

        return [
            'items' => $slice,
            'next_cursor' => $nextCursor,
            'limit' => $limit,
        ];
    }

    /** @param list<array<string,string>> $items */
    private function resolveStartIndex(array $items, ?string $cursor): int
    {
        if ($cursor === null || $cursor === '') {
            return 0;
        }

        $decoded = base64_decode(strtr($cursor, '-_', '+/'), true);
        if ($decoded === false) {
            return 0;
        }

        $parts = json_decode($decoded, true);
        if (!is_array($parts) || !is_string($parts['created_at_utc'] ?? null) || !is_string($parts['id'] ?? null)) {
            return 0;
        }

        foreach ($items as $index => $item) {
            $createdAt = (string) ($item['created_at_utc'] ?? '');
            $id = (string) ($item['id'] ?? '');
            if ($createdAt === (string) $parts['created_at_utc'] && $id === (string) $parts['id']) {
                return $index + 1;
            }
        }

        return 0;
    }

    private function encodeCursor(string $createdAtUtc, string $id): string
    {
        $payload = json_encode([
            'created_at_utc' => $createdAtUtc,
            'id' => $id,
        ], JSON_THROW_ON_ERROR);

        return rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');
    }
}
