<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class State implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'previous_outage' => ['previous_outage', \Acme\DigitalOcean\Generated\Model\PreviousOutage::class],
        'regions' => ['regions', \Acme\DigitalOcean\Generated\Model\RegionalState::class],
    ];

    public function __construct(
        public ?PreviousOutage $previous_outage = null,
        public ?RegionalState $regions = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'previous_outage' => $this->previous_outage,
            'regions' => $this->regions,
        ];
    }
}
