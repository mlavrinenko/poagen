<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppDatabaseSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'cluster_name' => ['cluster_name', null],
        'db_name' => ['db_name', null],
        'db_user' => ['db_user', null],
        'engine' => ['engine', null],
        'production' => ['production', null],
        'version' => ['version', null],
    ];

    public function __construct(
        public string $name,
        public ?string $cluster_name = null,
        public ?string $db_name = null,
        public ?string $db_user = null,
        public ?string $engine = null,
        public ?bool $production = null,
        public ?string $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'cluster_name' => $this->cluster_name,
            'db_name' => $this->db_name,
            'db_user' => $this->db_user,
            'engine' => $this->engine,
            'production' => $this->production,
            'version' => $this->version,
        ];
    }
}
