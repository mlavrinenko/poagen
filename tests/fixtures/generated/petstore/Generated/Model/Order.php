<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model;

final readonly class Order
{
    public function __construct(
        public ?bool $complete = null,
        public ?int $id = null,
        public ?int $petId = null,
        public ?int $quantity = null,
        public ?string $shipDate = null,
        public ?string $status = null,
    ) {
    }
}
