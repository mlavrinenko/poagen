<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\WireName;

final readonly class Order
{
    public function __construct(
        public ?int $id = null,
        #[WireName('pet_id')]
        public ?int $petId = null,
        public ?DateTimeImmutable $shipDate = null,
        public ?Status $status = null,
    ) {}
}
