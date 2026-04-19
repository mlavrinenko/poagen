<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ContentFile implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\ContentFile_links::class],
        'content' => ['content', null],
        'download_url' => ['download_url', null],
        'encoding' => ['encoding', null],
        'git_url' => ['git_url', null],
        'html_url' => ['html_url', null],
        'name' => ['name', null],
        'path' => ['path', null],
        'sha' => ['sha', null],
        'size' => ['size', null],
        'type' => ['type', null],
        'url' => ['url', null],
        'submodule_git_url' => ['submodule_git_url', null],
        'target' => ['target', null],
    ];

    public function __construct(
        public ContentFile_links $_links,
        public string $content,
        public ?string $download_url = null,
        public string $encoding,
        public ?string $git_url = null,
        public ?string $html_url = null,
        public string $name,
        public string $path,
        public string $sha,
        public int $size,
        public string $type,
        public string $url,
        public ?string $submodule_git_url = null,
        public ?string $target = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'content' => $this->content,
            'download_url' => $this->download_url,
            'encoding' => $this->encoding,
            'git_url' => $this->git_url,
            'html_url' => $this->html_url,
            'name' => $this->name,
            'path' => $this->path,
            'sha' => $this->sha,
            'size' => $this->size,
            'type' => $this->type,
            'url' => $this->url,
            'submodule_git_url' => $this->submodule_git_url,
            'target' => $this->target,
        ];
    }
}
