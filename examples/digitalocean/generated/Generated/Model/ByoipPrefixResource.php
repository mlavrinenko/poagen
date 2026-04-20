<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ByoipPrefixResource
{
    public function __construct(
        public ?DateTimeImmutable $assigned_at = null,
        public ?string $byoip = null,
        public ?int $id = null,
        public ?string $region = null,
        public ?string $resource = null,
    ) {
    }
}
