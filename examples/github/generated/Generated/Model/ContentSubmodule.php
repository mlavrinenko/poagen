<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ContentSubmodule
{
    public function __construct(
        public ContentSubmodule_links $_links,
        public ?string $download_url = null,
        public ?string $git_url = null,
        public ?string $html_url = null,
        public string $name,
        public string $path,
        public string $sha,
        public int $size,
        public string $submodule_git_url,
        public string $type,
        public string $url,
    ) {
    }
}
