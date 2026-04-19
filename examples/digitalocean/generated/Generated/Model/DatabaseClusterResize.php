<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DatabaseClusterResize implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'num_nodes' => ['num_nodes', null],
        'size' => ['size', null],
        'storage_size_mib' => ['storage_size_mib', null],
    ];

    public function __construct(
        public int $num_nodes,
        public string $size,
        public ?int $storage_size_mib = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'num_nodes' => $this->num_nodes,
            'size' => $this->size,
            'storage_size_mib' => $this->storage_size_mib,
        ];
    }
}
