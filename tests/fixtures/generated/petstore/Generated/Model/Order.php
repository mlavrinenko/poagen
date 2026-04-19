<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Order implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract. See ADR-007.
     *
     * phpName => [wireKey, shape]
     * shape is one of: null (scalar pass-through), `\FQCN::class` (model ref), ['list', null] (list<scalar>), ['list', \FQCN::class] (list<Model>), ['scalar', \FQCN::class] (ScalarBinding VO), ['datetime', null] (format: date-time → \DateTimeImmutable), ['date', null] (format: date → \DateTimeImmutable).
     *
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}>
     */
    public const array PROPERTY_MAP = [
        'complete' => ['complete', null],
        'id' => ['id', null],
        'petId' => ['petId', null],
        'quantity' => ['quantity', null],
        'shipDate' => ['shipDate', ['datetime', null]],
        'status' => ['status', null],
    ];

    public function __construct(
        public ?bool $complete = null,
        public ?int $id = null,
        public ?int $petId = null,
        public ?int $quantity = null,
        public ?DateTimeImmutable $shipDate = null,
        public ?string $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'complete' => $this->complete,
            'id' => $this->id,
            'petId' => $this->petId,
            'quantity' => $this->quantity,
            'shipDate' => $this->shipDate?->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
        ];
    }
}
