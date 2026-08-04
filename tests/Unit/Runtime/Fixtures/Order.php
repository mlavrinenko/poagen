<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit\Runtime\Fixtures;

use DateTimeImmutable;

final readonly class Order
{
    public function __construct(
        public ?int $id = null,
        #[\Poagen\Runtime\Attribute\WireName('pet_id')]
        public ?int $petId = null,
        public ?DateTimeImmutable $shipDate = null,
        public ?Status $status = null,
    ) {}
}
