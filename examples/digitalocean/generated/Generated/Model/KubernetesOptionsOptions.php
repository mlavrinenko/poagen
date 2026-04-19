<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KubernetesOptionsOptions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'regions' => ['regions', ['list', \Acme\DigitalOcean\Generated\Model\KubernetesRegion::class]],
        'sizes' => ['sizes', ['list', \Acme\DigitalOcean\Generated\Model\KubernetesSize::class]],
        'versions' => ['versions', ['list', \Acme\DigitalOcean\Generated\Model\KubernetesVersion::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\KubernetesRegion> $regions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\KubernetesSize> $sizes
     * @param ?list<\Acme\DigitalOcean\Generated\Model\KubernetesVersion> $versions
     */
    public function __construct(
        public ?array $regions = null,
        public ?array $sizes = null,
        public ?array $versions = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'regions' => $this->regions,
            'sizes' => $this->sizes,
            'versions' => $this->versions,
        ];
    }
}
