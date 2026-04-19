<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AddonsDimensionWithPrice implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'display_name' => ['display_name', null],
        'feature_name' => ['feature_name', null],
        'id' => ['id', null],
        'sku' => ['sku', null],
        'slug' => ['slug', null],
        'volumes' => ['volumes', ['list', \Acme\DigitalOcean\Generated\Model\AddonsDimensionVolumeWithPrice::class]],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\AddonsDimensionVolumeWithPrice> $volumes
     */
    public function __construct(
        public string $display_name,
        public string $feature_name,
        public int $id,
        public string $sku,
        public string $slug,
        public array $volumes,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'display_name' => $this->display_name,
            'feature_name' => $this->feature_name,
            'id' => $this->id,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'volumes' => $this->volumes,
        ];
    }
}
