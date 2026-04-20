<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class DatabaseCluster
{
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
}
