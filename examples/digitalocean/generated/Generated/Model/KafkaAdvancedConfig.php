<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KafkaAdvancedConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'auto_create_topics_enable' => ['auto_create_topics_enable', null],
        'compression_type' => ['compression_type', null],
        'connections_max_idle_ms' => ['connections_max_idle_ms', null],
        'default_replication_factor' => ['default_replication_factor', null],
        'group_initial_rebalance_delay_ms' => ['group_initial_rebalance_delay_ms', null],
        'group_max_session_timeout_ms' => ['group_max_session_timeout_ms', null],
        'group_min_session_timeout_ms' => ['group_min_session_timeout_ms', null],
        'log_cleaner_delete_retention_ms' => ['log_cleaner_delete_retention_ms', null],
        'log_cleaner_max_compaction_lag_ms' => ['log_cleaner_max_compaction_lag_ms', null],
        'log_cleaner_min_cleanable_ratio' => ['log_cleaner_min_cleanable_ratio', null],
        'log_cleaner_min_compaction_lag_ms' => ['log_cleaner_min_compaction_lag_ms', null],
        'log_cleanup_policy' => ['log_cleanup_policy', null],
        'log_flush_interval_messages' => ['log_flush_interval_messages', null],
        'log_flush_interval_ms' => ['log_flush_interval_ms', null],
        'log_index_interval_bytes' => ['log_index_interval_bytes', null],
        'log_index_size_max_bytes' => ['log_index_size_max_bytes', null],
        'log_message_downconversion_enable' => ['log_message_downconversion_enable', null],
        'log_message_timestamp_difference_max_ms' => ['log_message_timestamp_difference_max_ms', null],
        'log_message_timestamp_type' => ['log_message_timestamp_type', null],
        'log_preallocate' => ['log_preallocate', null],
        'log_retention_bytes' => ['log_retention_bytes', null],
        'log_retention_hours' => ['log_retention_hours', null],
        'log_retention_ms' => ['log_retention_ms', null],
        'log_roll_jitter_ms' => ['log_roll_jitter_ms', null],
        'log_roll_ms' => ['log_roll_ms', null],
        'log_segment_bytes' => ['log_segment_bytes', null],
        'log_segment_delete_delay_ms' => ['log_segment_delete_delay_ms', null],
        'max_connections_per_ip' => ['max_connections_per_ip', null],
        'max_incremental_fetch_session_cache_slots' => ['max_incremental_fetch_session_cache_slots', null],
        'message_max_bytes' => ['message_max_bytes', null],
        'min_insync_replicas' => ['min_insync_replicas', null],
        'num_partitions' => ['num_partitions', null],
        'offsets_retention_minutes' => ['offsets_retention_minutes', null],
        'producer_purgatory_purge_interval_requests' => ['producer_purgatory_purge_interval_requests', null],
        'replica_fetch_max_bytes' => ['replica_fetch_max_bytes', null],
        'replica_fetch_response_max_bytes' => ['replica_fetch_response_max_bytes', null],
        'schema_registry' => ['schema_registry', null],
        'socket_request_max_bytes' => ['socket_request_max_bytes', null],
        'transaction_remove_expired_transaction_cleanup_interval_ms' => [
            'transaction_remove_expired_transaction_cleanup_interval_ms',
            null,
        ],
        'transaction_state_log_segment_bytes' => ['transaction_state_log_segment_bytes', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'auto_create_topics_enable' => $this->auto_create_topics_enable,
            'compression_type' => $this->compression_type,
            'connections_max_idle_ms' => $this->connections_max_idle_ms,
            'default_replication_factor' => $this->default_replication_factor,
            'group_initial_rebalance_delay_ms' => $this->group_initial_rebalance_delay_ms,
            'group_max_session_timeout_ms' => $this->group_max_session_timeout_ms,
            'group_min_session_timeout_ms' => $this->group_min_session_timeout_ms,
            'log_cleaner_delete_retention_ms' => $this->log_cleaner_delete_retention_ms,
            'log_cleaner_max_compaction_lag_ms' => $this->log_cleaner_max_compaction_lag_ms,
            'log_cleaner_min_cleanable_ratio' => $this->log_cleaner_min_cleanable_ratio,
            'log_cleaner_min_compaction_lag_ms' => $this->log_cleaner_min_compaction_lag_ms,
            'log_cleanup_policy' => $this->log_cleanup_policy,
            'log_flush_interval_messages' => $this->log_flush_interval_messages,
            'log_flush_interval_ms' => $this->log_flush_interval_ms,
            'log_index_interval_bytes' => $this->log_index_interval_bytes,
            'log_index_size_max_bytes' => $this->log_index_size_max_bytes,
            'log_message_downconversion_enable' => $this->log_message_downconversion_enable,
            'log_message_timestamp_difference_max_ms' => $this->log_message_timestamp_difference_max_ms,
            'log_message_timestamp_type' => $this->log_message_timestamp_type,
            'log_preallocate' => $this->log_preallocate,
            'log_retention_bytes' => $this->log_retention_bytes,
            'log_retention_hours' => $this->log_retention_hours,
            'log_retention_ms' => $this->log_retention_ms,
            'log_roll_jitter_ms' => $this->log_roll_jitter_ms,
            'log_roll_ms' => $this->log_roll_ms,
            'log_segment_bytes' => $this->log_segment_bytes,
            'log_segment_delete_delay_ms' => $this->log_segment_delete_delay_ms,
            'max_connections_per_ip' => $this->max_connections_per_ip,
            'max_incremental_fetch_session_cache_slots' => $this->max_incremental_fetch_session_cache_slots,
            'message_max_bytes' => $this->message_max_bytes,
            'min_insync_replicas' => $this->min_insync_replicas,
            'num_partitions' => $this->num_partitions,
            'offsets_retention_minutes' => $this->offsets_retention_minutes,
            'producer_purgatory_purge_interval_requests' => $this->producer_purgatory_purge_interval_requests,
            'replica_fetch_max_bytes' => $this->replica_fetch_max_bytes,
            'replica_fetch_response_max_bytes' => $this->replica_fetch_response_max_bytes,
            'schema_registry' => $this->schema_registry,
            'socket_request_max_bytes' => $this->socket_request_max_bytes,
            'transaction_remove_expired_transaction_cleanup_interval_ms' => $this->transaction_remove_expired_transaction_cleanup_interval_ms,
            'transaction_state_log_segment_bytes' => $this->transaction_state_log_segment_bytes,
        ];
    }
}
