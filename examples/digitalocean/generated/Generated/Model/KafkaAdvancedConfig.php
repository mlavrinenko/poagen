<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KafkaAdvancedConfig
{
    public function __construct(
        public ?bool $auto_create_topics_enable = null,
        public ?string $compression_type = null,
        public ?int $connections_max_idle_ms = null,
        public ?int $default_replication_factor = null,
        public ?int $group_initial_rebalance_delay_ms = null,
        public ?int $group_max_session_timeout_ms = null,
        public ?int $group_min_session_timeout_ms = null,
        public ?int $log_cleaner_delete_retention_ms = null,
        public ?int $log_cleaner_max_compaction_lag_ms = null,
        public ?float $log_cleaner_min_cleanable_ratio = null,
        public ?int $log_cleaner_min_compaction_lag_ms = null,
        public ?string $log_cleanup_policy = null,
        public ?int $log_flush_interval_messages = null,
        public ?int $log_flush_interval_ms = null,
        public ?int $log_index_interval_bytes = null,
        public ?int $log_index_size_max_bytes = null,
        public ?bool $log_message_downconversion_enable = null,
        public ?int $log_message_timestamp_difference_max_ms = null,
        public ?string $log_message_timestamp_type = null,
        public ?bool $log_preallocate = null,
        public ?int $log_retention_bytes = null,
        public ?int $log_retention_hours = null,
        public ?int $log_retention_ms = null,
        public ?int $log_roll_jitter_ms = null,
        public ?int $log_roll_ms = null,
        public ?int $log_segment_bytes = null,
        public ?int $log_segment_delete_delay_ms = null,
        public ?int $max_connections_per_ip = null,
        public ?int $max_incremental_fetch_session_cache_slots = null,
        public ?int $message_max_bytes = null,
        public ?int $min_insync_replicas = null,
        public ?int $num_partitions = null,
        public ?int $offsets_retention_minutes = null,
        public ?int $producer_purgatory_purge_interval_requests = null,
        public ?int $replica_fetch_max_bytes = null,
        public ?int $replica_fetch_response_max_bytes = null,
        public ?bool $schema_registry = null,
        public ?int $socket_request_max_bytes = null,
        public ?int $transaction_remove_expired_transaction_cleanup_interval_ms = null,
        public ?int $transaction_state_log_segment_bytes = null,
    ) {
    }
}
