<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class LicenseContent
{
    public function __construct(
        public LicenseContent_links $_links,
        public string $content,
        public ?string $download_url = null,
        public string $encoding,
        public ?string $git_url = null,
        public ?string $html_url = null,
        public NullableLicenseSimple $license,
        public string $name,
        public string $path,
        public string $sha,
        public int $size,
        public string $type,
        public string $url,
    ) {
    }
}
