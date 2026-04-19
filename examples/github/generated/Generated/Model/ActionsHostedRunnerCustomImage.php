<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsHostedRunnerCustomImage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'latest_version' => ['latest_version', null],
        'name' => ['name', null],
        'platform' => ['platform', null],
        'source' => ['source', null],
        'state' => ['state', null],
        'total_versions_size' => ['total_versions_size', null],
        'versions_count' => ['versions_count', null],
    ];

    public function __construct(
        public int $id,
        public string $latest_version,
        public string $name,
        public string $platform,
        public string $source,
        public string $state,
        public int $total_versions_size,
        public int $versions_count,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'latest_version' => $this->latest_version,
            'name' => $this->name,
            'platform' => $this->platform,
            'source' => $this->source,
            'state' => $this->state,
            'total_versions_size' => $this->total_versions_size,
            'versions_count' => $this->versions_count,
        ];
    }
}
