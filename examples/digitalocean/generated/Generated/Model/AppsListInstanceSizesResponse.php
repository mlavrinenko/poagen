<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsListInstanceSizesResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'discount_percent' => ['discount_percent', null],
        'instance_sizes' => ['instance_sizes', ['list', \Acme\DigitalOcean\Generated\Model\AppsInstanceSize::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsInstanceSize> $instance_sizes
     */
    public function __construct(
        public ?float $discount_percent = null,
        public ?array $instance_sizes = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'discount_percent' => $this->discount_percent,
            'instance_sizes' => $this->instance_sizes,
        ];
    }
}
