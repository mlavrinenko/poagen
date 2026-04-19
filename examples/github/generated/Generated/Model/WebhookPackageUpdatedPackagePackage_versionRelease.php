<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPackageUpdatedPackagePackage_versionRelease implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => [
            'author',
            \Acme\GitHub\Generated\Model\WebhookPackageUpdatedPackagePackage_versionReleaseAuthor::class,
        ],
        'created_at' => ['created_at', null],
        'draft' => ['draft', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'prerelease' => ['prerelease', null],
        'published_at' => ['published_at', null],
        'tag_name' => ['tag_name', null],
        'target_commitish' => ['target_commitish', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public WebhookPackageUpdatedPackagePackage_versionReleaseAuthor $author,
        public string $created_at,
        public bool $draft,
        public string $html_url,
        public int $id,
        public string $name,
        public bool $prerelease,
        public string $published_at,
        public string $tag_name,
        public string $target_commitish,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'created_at' => $this->created_at,
            'draft' => $this->draft,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'prerelease' => $this->prerelease,
            'published_at' => $this->published_at,
            'tag_name' => $this->tag_name,
            'target_commitish' => $this->target_commitish,
            'url' => $this->url,
        ];
    }
}
