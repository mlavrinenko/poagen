<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class RepositoryTag
{
    public function __construct(
        public ?int $compressed_size_bytes = null,
        public ?string $manifest_digest = null,
        public ?string $registry_name = null,
        public ?string $repository = null,
        public ?int $size_bytes = null,
        public ?string $tag = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
