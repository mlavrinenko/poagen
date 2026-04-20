<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KubernetesOptionsOptions
{
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
}
