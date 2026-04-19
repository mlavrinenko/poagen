<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class PgbouncerAdvancedConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'autodb_idle_timeout' => ['autodb_idle_timeout', null],
        'autodb_max_db_connections' => ['autodb_max_db_connections', null],
        'autodb_pool_mode' => ['autodb_pool_mode', null],
        'autodb_pool_size' => ['autodb_pool_size', null],
        'ignore_startup_parameters' => ['ignore_startup_parameters', ['list', null]],
        'min_pool_size' => ['min_pool_size', null],
        'server_idle_timeout' => ['server_idle_timeout', null],
        'server_lifetime' => ['server_lifetime', null],
        'server_reset_query_always' => ['server_reset_query_always', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'autodb_idle_timeout' => $this->autodb_idle_timeout,
            'autodb_max_db_connections' => $this->autodb_max_db_connections,
            'autodb_pool_mode' => $this->autodb_pool_mode,
            'autodb_pool_size' => $this->autodb_pool_size,
            'ignore_startup_parameters' => $this->ignore_startup_parameters,
            'min_pool_size' => $this->min_pool_size,
            'server_idle_timeout' => $this->server_idle_timeout,
            'server_lifetime' => $this->server_lifetime,
            'server_reset_query_always' => $this->server_reset_query_always,
        ];
    }
}
