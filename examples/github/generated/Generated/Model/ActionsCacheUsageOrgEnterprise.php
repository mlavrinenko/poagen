<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsCacheUsageOrgEnterprise implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'total_active_caches_count' => ['total_active_caches_count', null],
        'total_active_caches_size_in_bytes' => ['total_active_caches_size_in_bytes', null],
    ];

    public function __construct(
        public int $total_active_caches_count,
        public int $total_active_caches_size_in_bytes,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'total_active_caches_count' => $this->total_active_caches_count,
            'total_active_caches_size_in_bytes' => $this->total_active_caches_size_in_bytes,
        ];
    }
}
