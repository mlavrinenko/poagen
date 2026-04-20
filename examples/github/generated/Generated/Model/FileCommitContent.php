<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class FileCommitContent
{
    public function __construct(
        public ?FileCommitContent_links $_links = null,
        public ?string $download_url = null,
        public ?string $git_url = null,
        public ?string $html_url = null,
        public ?string $name = null,
        public ?string $path = null,
        public ?string $sha = null,
        public ?int $size = null,
        public ?string $type = null,
        public ?string $url = null,
    ) {
    }
}
