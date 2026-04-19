<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ContentSymlink implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\ContentSymlink_links::class],
        'download_url' => ['download_url', null],
        'git_url' => ['git_url', null],
        'html_url' => ['html_url', null],
        'name' => ['name', null],
        'path' => ['path', null],
        'sha' => ['sha', null],
        'size' => ['size', null],
        'target' => ['target', null],
        'type' => ['type', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public ContentSymlink_links $_links,
        public ?string $download_url = null,
        public ?string $git_url = null,
        public ?string $html_url = null,
        public string $name,
        public string $path,
        public string $sha,
        public int $size,
        public string $target,
        public string $type,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'download_url' => $this->download_url,
            'git_url' => $this->git_url,
            'html_url' => $this->html_url,
            'name' => $this->name,
            'path' => $this->path,
            'sha' => $this->sha,
            'size' => $this->size,
            'target' => $this->target,
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
