<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookPushHead_commit
{
    /**
     * @param ?list<string> $added
     * @param ?list<string> $modified
     * @param ?list<string> $removed
     */
    public function __construct(
        public WebhookPushHead_commitAuthor $author,
        public WebhookPushHead_commitCommitter $committer,
        public bool $distinct,
        public string $id,
        public string $message,
        public DateTimeImmutable $timestamp,
        public string $tree_id,
        public string $url,
        public ?array $added = null,
        public ?array $modified = null,
        public ?array $removed = null,
    ) {
    }
}
