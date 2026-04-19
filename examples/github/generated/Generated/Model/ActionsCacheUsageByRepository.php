<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsCacheUsageByRepository implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'active_caches_count' => ['active_caches_count', null],
        'active_caches_size_in_bytes' => ['active_caches_size_in_bytes', null],
        'full_name' => ['full_name', null],
    ];

    public function __construct(
        public int $active_caches_count,
        public int $active_caches_size_in_bytes,
        public string $full_name,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'active_caches_count' => $this->active_caches_count,
            'active_caches_size_in_bytes' => $this->active_caches_size_in_bytes,
            'full_name' => $this->full_name,
        ];
    }
}
