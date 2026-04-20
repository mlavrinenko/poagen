<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ContentTree
{
    /**
     * @param ?list<array<string, mixed>> $entries
     */
    public function __construct(
        public ContentTree_links $_links,
        public ?string $download_url = null,
        public ?string $git_url = null,
        public ?string $html_url = null,
        public string $name,
        public string $path,
        public string $sha,
        public int $size,
        public string $type,
        public string $url,
        public ?string $content = null,
        public ?string $encoding = null,
        public ?array $entries = null,
    ) {
    }
}
