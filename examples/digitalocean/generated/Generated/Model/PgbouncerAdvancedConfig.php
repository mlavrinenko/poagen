<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class PgbouncerAdvancedConfig
{
    /**
     * @param ?list<string> $ignore_startup_parameters
     */
    public function __construct(
        public ?int $autodb_idle_timeout = null,
        public ?int $autodb_max_db_connections = null,
        public ?string $autodb_pool_mode = null,
        public ?int $autodb_pool_size = null,
        public ?array $ignore_startup_parameters = null,
        public ?int $min_pool_size = null,
        public ?int $server_idle_timeout = null,
        public ?int $server_lifetime = null,
        public ?bool $server_reset_query_always = null,
    ) {
    }
}
