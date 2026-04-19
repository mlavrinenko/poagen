<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsListRegionsResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'regions' => ['regions', ['list', \Acme\DigitalOcean\Generated\Model\AppsRegion::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsRegion> $regions
     */
    public function __construct(
        public ?array $regions = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'regions' => $this->regions,
        ];
    }
}
