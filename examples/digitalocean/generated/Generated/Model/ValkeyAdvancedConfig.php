<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\EvictionPolicyModel;
use JsonSerializable;

final readonly class ValkeyAdvancedConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'frequent_snapshots' => ['frequent_snapshots', null],
        'valkey_acl_channels_default' => ['valkey_acl_channels_default', null],
        'valkey_active_expire_effort' => ['valkey_active_expire_effort', null],
        'valkey_io_threads' => ['valkey_io_threads', null],
        'valkey_lfu_decay_time' => ['valkey_lfu_decay_time', null],
        'valkey_lfu_log_factor' => ['valkey_lfu_log_factor', null],
        'valkey_maxmemory_policy' => [
            'valkey_maxmemory_policy',
            ['enum', \Acme\DigitalOcean\Generated\Enum\EvictionPolicyModel::class],
        ],
        'valkey_notify_keyspace_events' => ['valkey_notify_keyspace_events', null],
        'valkey_number_of_databases' => ['valkey_number_of_databases', null],
        'valkey_persistence' => ['valkey_persistence', null],
        'valkey_pubsub_client_output_buffer_limit' => ['valkey_pubsub_client_output_buffer_limit', null],
        'valkey_ssl' => ['valkey_ssl', null],
        'valkey_timeout' => ['valkey_timeout', null],
    ];

    public function __construct(
        public ?bool $frequent_snapshots = null,
        public ?string $valkey_acl_channels_default = null,
        public ?int $valkey_active_expire_effort = null,
        public ?int $valkey_io_threads = null,
        public ?int $valkey_lfu_decay_time = null,
        public ?int $valkey_lfu_log_factor = null,
        public ?EvictionPolicyModel $valkey_maxmemory_policy = null,
        public ?string $valkey_notify_keyspace_events = null,
        public ?int $valkey_number_of_databases = null,
        public ?string $valkey_persistence = null,
        public ?int $valkey_pubsub_client_output_buffer_limit = null,
        public ?bool $valkey_ssl = null,
        public ?int $valkey_timeout = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'frequent_snapshots' => $this->frequent_snapshots,
            'valkey_acl_channels_default' => $this->valkey_acl_channels_default,
            'valkey_active_expire_effort' => $this->valkey_active_expire_effort,
            'valkey_io_threads' => $this->valkey_io_threads,
            'valkey_lfu_decay_time' => $this->valkey_lfu_decay_time,
            'valkey_lfu_log_factor' => $this->valkey_lfu_log_factor,
            'valkey_maxmemory_policy' => $this->valkey_maxmemory_policy,
            'valkey_notify_keyspace_events' => $this->valkey_notify_keyspace_events,
            'valkey_number_of_databases' => $this->valkey_number_of_databases,
            'valkey_persistence' => $this->valkey_persistence,
            'valkey_pubsub_client_output_buffer_limit' => $this->valkey_pubsub_client_output_buffer_limit,
            'valkey_ssl' => $this->valkey_ssl,
            'valkey_timeout' => $this->valkey_timeout,
        ];
    }
}
