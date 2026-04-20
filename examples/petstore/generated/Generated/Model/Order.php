<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Model;

use DateTimeImmutable;

final readonly class Order
{
    public function __construct(
        public ?bool $complete = null,
        public ?int $id = null,
        public ?int $petId = null,
        public ?int $quantity = null,
        public ?DateTimeImmutable $shipDate = null,
        public ?string $status = null,
    ) {
    }
}
