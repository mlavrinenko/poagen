<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class InvoiceItem implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'amount' => ['amount', null],
        'description' => ['description', null],
        'duration' => ['duration', null],
        'duration_unit' => ['duration_unit', null],
        'end_time' => ['end_time', null],
        'group_description' => ['group_description', null],
        'product' => ['product', null],
        'project_name' => ['project_name', null],
        'resource_id' => ['resource_id', null],
        'resource_uuid' => ['resource_uuid', null],
        'start_time' => ['start_time', null],
    ];

    public function __construct(
        public ?string $amount = null,
        public ?string $description = null,
        public ?string $duration = null,
        public ?string $duration_unit = null,
        public ?string $end_time = null,
        public ?string $group_description = null,
        public ?string $product = null,
        public ?string $project_name = null,
        public ?string $resource_id = null,
        public ?string $resource_uuid = null,
        public ?string $start_time = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'description' => $this->description,
            'duration' => $this->duration,
            'duration_unit' => $this->duration_unit,
            'end_time' => $this->end_time,
            'group_description' => $this->group_description,
            'product' => $this->product,
            'project_name' => $this->project_name,
            'resource_id' => $this->resource_id,
            'resource_uuid' => $this->resource_uuid,
            'start_time' => $this->start_time,
        ];
    }
}
