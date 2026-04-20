<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KubernetesNodePoolBase
{
    /**
     * @param ?array<string, mixed> $labels
     * @param ?list<\Acme\DigitalOcean\Generated\Model\Node> $nodes
     * @param ?list<string> $tags
     * @param ?list<\Acme\DigitalOcean\Generated\Model\KubernetesNodePoolTaint> $taints
     */
    public function __construct(
        public ?bool $auto_scale = null,
        public ?int $count = null,
        public ?string $id = null,
        public ?array $labels = null,
        public ?int $max_nodes = null,
        public ?int $min_nodes = null,
        public ?string $name = null,
        public ?array $nodes = null,
        public ?array $tags = null,
        public ?array $taints = null,
    ) {
    }
}
