<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ProjectBase
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?string $environment = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?int $owner_id = null,
        public ?string $owner_uuid = null,
        public ?string $purpose = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
