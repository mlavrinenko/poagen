<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class NamespaceInfo implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'api_host' => ['api_host', null],
        'created_at' => ['created_at', null],
        'key' => ['key', null],
        'label' => ['label', null],
        'namespace' => ['namespace', null],
        'region' => ['region', null],
        'updated_at' => ['updated_at', null],
        'uuid' => ['uuid', null],
    ];

    public function __construct(
        public ?string $api_host = null,
        public ?string $created_at = null,
        public ?string $key = null,
        public ?string $label = null,
        public ?string $namespace = null,
        public ?string $region = null,
        public ?string $updated_at = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'api_host' => $this->api_host,
            'created_at' => $this->created_at,
            'key' => $this->key,
            'label' => $this->label,
            'namespace' => $this->namespace,
            'region' => $this->region,
            'updated_at' => $this->updated_at,
            'uuid' => $this->uuid,
        ];
    }
}
