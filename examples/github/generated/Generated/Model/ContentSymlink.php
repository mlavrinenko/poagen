<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ContentSymlink
{
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
}
