<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ReleaseAsset implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'browser_download_url' => ['browser_download_url', null],
        'content_type' => ['content_type', null],
        'created_at' => ['created_at', ['datetime', null]],
        'digest' => ['digest', null],
        'download_count' => ['download_count', null],
        'id' => ['id', null],
        'label' => ['label', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'size' => ['size', null],
        'state' => ['state', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uploader' => ['uploader', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'url' => ['url', null],
    ];

    public function __construct(
        public string $browser_download_url,
        public string $content_type,
        public DateTimeImmutable $created_at,
        public ?string $digest = null,
        public int $download_count,
        public int $id,
        public ?string $label = null,
        public string $name,
        public string $node_id,
        public int $size,
        public string $state,
        public DateTimeImmutable $updated_at,
        public NullableSimpleUser $uploader,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'browser_download_url' => $this->browser_download_url,
            'content_type' => $this->content_type,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'digest' => $this->digest,
            'download_count' => $this->download_count,
            'id' => $this->id,
            'label' => $this->label,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'size' => $this->size,
            'state' => $this->state,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'uploader' => $this->uploader,
            'url' => $this->url,
        ];
    }
}
