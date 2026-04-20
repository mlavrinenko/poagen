<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Node
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $droplet_id = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?NodeStatus $status = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
