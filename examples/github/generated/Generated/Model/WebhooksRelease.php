<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksRelease
{
    /**
     * @param list<array<string, mixed>> $assets
     */
    public function __construct(
        public array $assets,
        public string $assets_url,
        public WebhooksReleaseAuthor $author,
        public ?string $body = null,
        public ?DateTimeImmutable $created_at = null,
        public bool $draft,
        public string $html_url,
        public int $id,
        public bool $immutable,
        public ?string $name = null,
        public string $node_id,
        public bool $prerelease,
        public ?DateTimeImmutable $published_at = null,
        public string $tag_name,
        public ?string $tarball_url = null,
        public string $target_commitish,
        public ?DateTimeImmutable $updated_at = null,
        public string $upload_url,
        public string $url,
        public ?string $zipball_url = null,
        public ?string $discussion_url = null,
        public ?WebhooksReleaseReactions $reactions = null,
    ) {
    }
}
