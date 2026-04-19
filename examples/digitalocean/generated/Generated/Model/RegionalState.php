<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class RegionalState implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'eu_west' => ['eu_west', \Acme\DigitalOcean\Generated\Model\RegionState::class],
        'us_east' => ['us_east', \Acme\DigitalOcean\Generated\Model\RegionState::class],
    ];

    public function __construct(
        public ?RegionState $eu_west = null,
        public ?RegionState $us_east = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'eu_west' => $this->eu_west,
            'us_east' => $this->us_east,
        ];
    }
}
