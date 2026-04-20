<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DiffEntry
{
    public function __construct(
        public int $additions,
        public string $blob_url,
        public int $changes,
        public string $contents_url,
        public int $deletions,
        public string $filename,
        public string $raw_url,
        public ?string $sha = null,
        public string $status,
        public ?string $patch = null,
        public ?string $previous_filename = null,
    ) {
    }
}
