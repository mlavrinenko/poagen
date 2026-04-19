<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KubernetesNodePoolUpdate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'auto_scale' => ['auto_scale', null],
        'count' => ['count', null],
        'id' => ['id', null],
        'labels' => ['labels', null],
        'max_nodes' => ['max_nodes', null],
        'min_nodes' => ['min_nodes', null],
        'name' => ['name', null],
        'nodes' => ['nodes', ['list', \Acme\DigitalOcean\Generated\Model\Node::class]],
        'tags' => ['tags', ['list', null]],
        'taints' => ['taints', ['list', \Acme\DigitalOcean\Generated\Model\KubernetesNodePoolTaint::class]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'auto_scale' => $this->auto_scale,
            'count' => $this->count,
            'id' => $this->id,
            'labels' => $this->labels,
            'max_nodes' => $this->max_nodes,
            'min_nodes' => $this->min_nodes,
            'name' => $this->name,
            'nodes' => $this->nodes,
            'tags' => $this->tags,
            'taints' => $this->taints,
        ];
    }
}
