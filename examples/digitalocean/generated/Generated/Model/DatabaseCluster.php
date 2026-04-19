<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DatabaseCluster implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'engine' => ['engine', null],
        'name' => ['name', null],
        'num_nodes' => ['num_nodes', null],
        'region' => ['region', null],
        'size' => ['size', null],
        'autoscale' => ['autoscale', null],
        'connection' => ['connection', null],
        'created_at' => ['created_at', ['datetime', null]],
        'db_names' => ['db_names', ['list', null]],
        'do_settings' => ['do_settings', null],
        'id' => ['id', null],
        'maintenance_window' => ['maintenance_window', null],
        'metrics_endpoints' => [
            'metrics_endpoints',
            ['list', \Acme\DigitalOcean\Generated\Model\DatabaseServiceEndpoint::class],
        ],
        'private_connection' => ['private_connection', null],
        'private_network_uuid' => ['private_network_uuid', null],
        'project_id' => ['project_id', null],
        'rules' => ['rules', ['list', \Acme\DigitalOcean\Generated\Model\FirewallRule::class]],
        'schema_registry_connection' => ['schema_registry_connection', null],
        'semantic_version' => ['semantic_version', null],
        'standby_connection' => ['standby_connection', null],
        'standby_private_connection' => ['standby_private_connection', null],
        'status' => ['status', null],
        'storage_size_mib' => ['storage_size_mib', null],
        'tags' => ['tags', ['list', null]],
        'ui_connection' => ['ui_connection', null],
        'users' => ['users', ['list', \Acme\DigitalOcean\Generated\Model\DatabaseUser::class]],
        'version' => ['version', null],
        'version_end_of_availability' => ['version_end_of_availability', null],
        'version_end_of_life' => ['version_end_of_life', null],
    ];

    /**
     * @param ?mixed $autoscale
     * @param ?mixed $connection
     * @param ?list<string> $db_names
     * @param ?mixed $do_settings
     * @param ?mixed $maintenance_window
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DatabaseServiceEndpoint> $metrics_endpoints
     * @param ?mixed $private_connection
     * @param ?list<\Acme\DigitalOcean\Generated\Model\FirewallRule> $rules
     * @param ?mixed $schema_registry_connection
     * @param ?mixed $standby_connection
     * @param ?mixed $standby_private_connection
     * @param ?list<string> $tags
     * @param ?mixed $ui_connection
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DatabaseUser> $users
     */
    public function __construct(
        public string $engine,
        public string $name,
        public int $num_nodes,
        public string $region,
        public string $size,
        public $autoscale = null,
        public $connection = null,
        public ?DateTimeImmutable $created_at = null,
        public ?array $db_names = null,
        public $do_settings = null,
        public ?string $id = null,
        public $maintenance_window = null,
        public ?array $metrics_endpoints = null,
        public $private_connection = null,
        public ?string $private_network_uuid = null,
        public ?string $project_id = null,
        public ?array $rules = null,
        public $schema_registry_connection = null,
        public ?string $semantic_version = null,
        public $standby_connection = null,
        public $standby_private_connection = null,
        public ?string $status = null,
        public ?int $storage_size_mib = null,
        public ?array $tags = null,
        public $ui_connection = null,
        public ?array $users = null,
        public ?string $version = null,
        public ?string $version_end_of_availability = null,
        public ?string $version_end_of_life = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'engine' => $this->engine,
            'name' => $this->name,
            'num_nodes' => $this->num_nodes,
            'region' => $this->region,
            'size' => $this->size,
            'autoscale' => $this->autoscale,
            'connection' => $this->connection,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'db_names' => $this->db_names,
            'do_settings' => $this->do_settings,
            'id' => $this->id,
            'maintenance_window' => $this->maintenance_window,
            'metrics_endpoints' => $this->metrics_endpoints,
            'private_connection' => $this->private_connection,
            'private_network_uuid' => $this->private_network_uuid,
            'project_id' => $this->project_id,
            'rules' => $this->rules,
            'schema_registry_connection' => $this->schema_registry_connection,
            'semantic_version' => $this->semantic_version,
            'standby_connection' => $this->standby_connection,
            'standby_private_connection' => $this->standby_private_connection,
            'status' => $this->status,
            'storage_size_mib' => $this->storage_size_mib,
            'tags' => $this->tags,
            'ui_connection' => $this->ui_connection,
            'users' => $this->users,
            'version' => $this->version,
            'version_end_of_availability' => $this->version_end_of_availability,
            'version_end_of_life' => $this->version_end_of_life,
        ];
    }
}
