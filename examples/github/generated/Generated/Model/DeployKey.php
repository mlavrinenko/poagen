<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class DeployKey
{
    public function __construct(
        public string $created_at,
        public int $id,
        public string $key,
        public bool $read_only,
        public string $title,
        public string $url,
        public bool $verified,
        public ?string $added_by = null,
        public ?bool $enabled = null,
        public ?DateTimeImmutable $last_used = null,
    ) {
    }
}
