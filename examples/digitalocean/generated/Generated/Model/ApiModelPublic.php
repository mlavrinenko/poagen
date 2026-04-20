<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiModelPublic
{
    public function __construct(
        public ?ApiAgreement $agreement = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?bool $is_foundational = null,
        public ?int $kb_default_chunk_size = null,
        public ?int $kb_max_chunk_size = null,
        public ?int $kb_min_chunk_size = null,
        public ?string $name = null,
        public ?string $parent_uuid = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?bool $upload_complete = null,
        public ?string $url = null,
        public ?string $uuid = null,
        public ?ApiModelVersion $version = null,
    ) {
    }
}
