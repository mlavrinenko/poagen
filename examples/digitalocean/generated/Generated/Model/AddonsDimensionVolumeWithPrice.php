<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AddonsDimensionVolumeWithPrice implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'low_volume' => ['low_volume', null],
        'max_volume' => ['max_volume', null],
        'price_per_unit' => ['price_per_unit', null],
    ];

    public function __construct(
        public int $id,
        public int $low_volume,
        public int $max_volume,
        public string $price_per_unit,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'low_volume' => $this->low_volume,
            'max_volume' => $this->max_volume,
            'price_per_unit' => $this->price_per_unit,
        ];
    }
}
