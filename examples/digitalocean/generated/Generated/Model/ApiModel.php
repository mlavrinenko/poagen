<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiModelProvider;
use DateTimeImmutable;

final readonly class ApiModel
{
    /**
     * @param ?array<string, mixed> $metadata
     * @param ?list<\Acme\DigitalOcean\Generated\Enum\ApiModelUsecase> $usecases
     */
    public function __construct(
        public ?ApiAgreement $agreement = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $inference_name = null,
        public ?string $inference_version = null,
        public ?bool $is_foundational = null,
        public ?int $kb_default_chunk_size = null,
        public ?int $kb_max_chunk_size = null,
        public ?int $kb_min_chunk_size = null,
        public ?array $metadata = null,
        public ?string $name = null,
        public ?string $parent_uuid = null,
        public ?ApiModelProvider $provider = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?bool $upload_complete = null,
        public ?string $url = null,
        public ?array $usecases = null,
        public ?string $uuid = null,
        public ?ApiModelVersion $version = null,
    ) {
    }
}
