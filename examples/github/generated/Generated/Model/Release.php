<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Release
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\ReleaseAsset> $assets
     */
    public function __construct(
        public array $assets,
        public string $assets_url,
        public SimpleUser $author,
        public DateTimeImmutable $created_at,
        public bool $draft,
        public string $html_url,
        public int $id,
        public ?string $name = null,
        public string $node_id,
        public bool $prerelease,
        public ?DateTimeImmutable $published_at = null,
        public string $tag_name,
        public ?string $tarball_url = null,
        public string $target_commitish,
        public string $upload_url,
        public string $url,
        public ?string $zipball_url = null,
        public ?string $body = null,
        public ?string $body_html = null,
        public ?string $body_text = null,
        public ?string $discussion_url = null,
        public ?bool $immutable = null,
        public ?int $mentions_count = null,
        public ?ReactionRollup $reactions = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
