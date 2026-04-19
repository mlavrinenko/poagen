<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Release implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'assets' => ['assets', ['list', \Acme\GitHub\Generated\Model\ReleaseAsset::class]],
        'assets_url' => ['assets_url', null],
        'author' => ['author', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'created_at' => ['created_at', ['datetime', null]],
        'draft' => ['draft', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'prerelease' => ['prerelease', null],
        'published_at' => ['published_at', ['datetime', null]],
        'tag_name' => ['tag_name', null],
        'tarball_url' => ['tarball_url', null],
        'target_commitish' => ['target_commitish', null],
        'upload_url' => ['upload_url', null],
        'url' => ['url', null],
        'zipball_url' => ['zipball_url', null],
        'body' => ['body', null],
        'body_html' => ['body_html', null],
        'body_text' => ['body_text', null],
        'discussion_url' => ['discussion_url', null],
        'immutable' => ['immutable', null],
        'mentions_count' => ['mentions_count', null],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\ReactionRollup::class],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'assets' => $this->assets,
            'assets_url' => $this->assets_url,
            'author' => $this->author,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'draft' => $this->draft,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'prerelease' => $this->prerelease,
            'published_at' => $this->published_at?->format(\DateTimeInterface::RFC3339),
            'tag_name' => $this->tag_name,
            'tarball_url' => $this->tarball_url,
            'target_commitish' => $this->target_commitish,
            'upload_url' => $this->upload_url,
            'url' => $this->url,
            'zipball_url' => $this->zipball_url,
            'body' => $this->body,
            'body_html' => $this->body_html,
            'body_text' => $this->body_text,
            'discussion_url' => $this->discussion_url,
            'immutable' => $this->immutable,
            'mentions_count' => $this->mentions_count,
            'reactions' => $this->reactions,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
