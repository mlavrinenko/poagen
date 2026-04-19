<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class Region implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'available' => ['available', null],
        'features' => ['features', ['list', null]],
        'name' => ['name', null],
        'sizes' => ['sizes', ['list', null]],
        'slug' => ['slug', null],
    ];

    /**
     * @param list<string> $features
     * @param list<string> $sizes
     */
    public function __construct(
        public bool $available,
        public array $features,
        public string $name,
        public array $sizes,
        public string $slug,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'available' => $this->available,
            'features' => $this->features,
            'name' => $this->name,
            'sizes' => $this->sizes,
            'slug' => $this->slug,
        ];
    }
}
