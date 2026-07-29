<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum\OrderStatus;

final readonly class Order
{
    public function __construct(
        public ?bool $complete = null,
        public ?int $id = null,
        public ?int $petId = null,
        public ?int $quantity = null,
        public ?DateTimeImmutable $shipDate = null,
        public ?OrderStatus $status = null,
    ) {
    }
}
