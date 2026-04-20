<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KubernetesVersion
{
    /**
     * @param ?list<string> $supported_features
     */
    public function __construct(
        public ?string $kubernetes_version = null,
        public ?string $slug = null,
        public ?array $supported_features = null,
    ) {
    }
}
