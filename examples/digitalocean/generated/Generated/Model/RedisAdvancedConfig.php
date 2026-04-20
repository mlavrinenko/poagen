<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class RedisAdvancedConfig
{
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
}
