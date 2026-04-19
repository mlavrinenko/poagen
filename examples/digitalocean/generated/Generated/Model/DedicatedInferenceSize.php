<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DedicatedInferenceSize implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'currency' => ['currency', null],
        'gpu_slug' => ['gpu_slug', null],
        'price_per_hour' => ['price_per_hour', null],
        'region' => ['region', null],
    ];

    public function __construct(
        public ?string $currency = null,
        public ?string $gpu_slug = null,
        public ?string $price_per_hour = null,
        public ?string $region = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'currency' => $this->currency,
            'gpu_slug' => $this->gpu_slug,
            'price_per_hour' => $this->price_per_hour,
            'region' => $this->region,
        ];
    }
}
