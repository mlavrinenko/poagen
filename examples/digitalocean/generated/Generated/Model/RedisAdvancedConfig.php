<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class RedisAdvancedConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'redis_acl_channels_default' => ['redis_acl_channels_default', null],
        'redis_io_threads' => ['redis_io_threads', null],
        'redis_lfu_decay_time' => ['redis_lfu_decay_time', null],
        'redis_lfu_log_factor' => ['redis_lfu_log_factor', null],
        'redis_maxmemory_policy' => ['redis_maxmemory_policy', null],
        'redis_notify_keyspace_events' => ['redis_notify_keyspace_events', null],
        'redis_number_of_databases' => ['redis_number_of_databases', null],
        'redis_persistence' => ['redis_persistence', null],
        'redis_pubsub_client_output_buffer_limit' => ['redis_pubsub_client_output_buffer_limit', null],
        'redis_ssl' => ['redis_ssl', null],
        'redis_timeout' => ['redis_timeout', null],
    ];

    public function __construct(
        public ?string $redis_acl_channels_default = null,
        public ?int $redis_io_threads = null,
        public ?int $redis_lfu_decay_time = null,
        public ?int $redis_lfu_log_factor = null,
        public ?string $redis_maxmemory_policy = null,
        public ?string $redis_notify_keyspace_events = null,
        public ?int $redis_number_of_databases = null,
        public ?string $redis_persistence = null,
        public ?int $redis_pubsub_client_output_buffer_limit = null,
        public ?bool $redis_ssl = null,
        public ?int $redis_timeout = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'redis_acl_channels_default' => $this->redis_acl_channels_default,
            'redis_io_threads' => $this->redis_io_threads,
            'redis_lfu_decay_time' => $this->redis_lfu_decay_time,
            'redis_lfu_log_factor' => $this->redis_lfu_log_factor,
            'redis_maxmemory_policy' => $this->redis_maxmemory_policy,
            'redis_notify_keyspace_events' => $this->redis_notify_keyspace_events,
            'redis_number_of_databases' => $this->redis_number_of_databases,
            'redis_persistence' => $this->redis_persistence,
            'redis_pubsub_client_output_buffer_limit' => $this->redis_pubsub_client_output_buffer_limit,
            'redis_ssl' => $this->redis_ssl,
            'redis_timeout' => $this->redis_timeout,
        ];
    }
}
