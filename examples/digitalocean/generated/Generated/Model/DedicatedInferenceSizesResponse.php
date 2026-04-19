<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DedicatedInferenceSizesResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enabled_regions' => ['enabled_regions', ['list', null]],
        'sizes' => ['sizes', ['list', \Acme\DigitalOcean\Generated\Model\DedicatedInferenceSize::class]],
    ];

    /**
     * @param ?list<string> $enabled_regions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DedicatedInferenceSize> $sizes
     */
    public function __construct(
        public ?array $enabled_regions = null,
        public ?array $sizes = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enabled_regions' => $this->enabled_regions,
            'sizes' => $this->sizes,
        ];
    }
}
