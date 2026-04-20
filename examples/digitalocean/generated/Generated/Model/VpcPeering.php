<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class VpcPeering
{
    /**
     * @param ?list<string> $vpc_ids
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $status = null,
        public ?array $vpc_ids = null,
    ) {
    }
}
