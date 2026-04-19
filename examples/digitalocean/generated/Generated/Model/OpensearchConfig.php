<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class OpensearchConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'endpoint' => ['endpoint', null],
        'cluster_name' => ['cluster_name', null],
        'cluster_uuid' => ['cluster_uuid', null],
        'credentials' => ['credentials', \Acme\DigitalOcean\Generated\Model\OpensearchConfigCredentials::class],
        'id' => ['id', null],
        'index_name' => ['index_name', null],
        'retention_days' => ['retention_days', null],
    ];

    public function __construct(
        public string $endpoint,
        public ?string $cluster_name = null,
        public ?string $cluster_uuid = null,
        public ?OpensearchConfigCredentials $credentials = null,
        public ?string $id = null,
        public ?string $index_name = null,
        public ?int $retention_days = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'endpoint' => $this->endpoint,
            'cluster_name' => $this->cluster_name,
            'cluster_uuid' => $this->cluster_uuid,
            'credentials' => $this->credentials,
            'id' => $this->id,
            'index_name' => $this->index_name,
            'retention_days' => $this->retention_days,
        ];
    }
}
