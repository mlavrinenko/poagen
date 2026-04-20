<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class RepositoryManifest
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\RepositoryBlob> $blobs
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?array $blobs = null,
        public ?int $compressed_size_bytes = null,
        public ?string $digest = null,
        public ?string $registry_name = null,
        public ?string $repository = null,
        public ?int $size_bytes = null,
        public ?array $tags = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
