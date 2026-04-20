<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\EvictionPolicyModel;

final readonly class ValkeyAdvancedConfig
{
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
}
