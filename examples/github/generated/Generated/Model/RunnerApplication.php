<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RunnerApplication
{
    public function __construct(
        public string $architecture,
        public string $download_url,
        public string $filename,
        public string $os,
        public ?string $sha256_checksum = null,
        public ?string $temp_download_token = null,
    ) {
    }
}
