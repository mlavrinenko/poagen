<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhooksRelease implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'assets' => ['assets', ['list', null]],
        'assets_url' => ['assets_url', null],
        'author' => ['author', \Acme\GitHub\Generated\Model\WebhooksReleaseAuthor::class],
        'body' => ['body', null],
        'created_at' => ['created_at', ['datetime', null]],
        'draft' => ['draft', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'immutable' => ['immutable', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'prerelease' => ['prerelease', null],
        'published_at' => ['published_at', ['datetime', null]],
        'tag_name' => ['tag_name', null],
        'tarball_url' => ['tarball_url', null],
        'target_commitish' => ['target_commitish', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'upload_url' => ['upload_url', null],
        'url' => ['url', null],
        'zipball_url' => ['zipball_url', null],
        'discussion_url' => ['discussion_url', null],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\WebhooksReleaseReactions::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'assets' => $this->assets,
            'assets_url' => $this->assets_url,
            'author' => $this->author,
            'body' => $this->body,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'draft' => $this->draft,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'immutable' => $this->immutable,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'prerelease' => $this->prerelease,
            'published_at' => $this->published_at?->format(\DateTimeInterface::RFC3339),
            'tag_name' => $this->tag_name,
            'tarball_url' => $this->tarball_url,
            'target_commitish' => $this->target_commitish,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'upload_url' => $this->upload_url,
            'url' => $this->url,
            'zipball_url' => $this->zipball_url,
            'discussion_url' => $this->discussion_url,
            'reactions' => $this->reactions,
        ];
    }
}
