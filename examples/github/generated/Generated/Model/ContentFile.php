<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ContentFile
{
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
}
