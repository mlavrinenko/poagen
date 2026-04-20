<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Mlavrinenko\Paogen\Runtime\Attribute\WireName;

final readonly class PostgresAdvancedConfig
{
    public function __construct(
        public ?float $autovacuum_analyze_scale_factor = null,
        public ?int $autovacuum_analyze_threshold = null,
        public ?int $autovacuum_freeze_max_age = null,
        public ?int $autovacuum_max_workers = null,
        public ?int $autovacuum_naptime = null,
        public ?int $autovacuum_vacuum_cost_delay = null,
        public ?int $autovacuum_vacuum_cost_limit = null,
        public ?float $autovacuum_vacuum_scale_factor = null,
        public ?int $autovacuum_vacuum_threshold = null,
        public ?int $backup_hour = null,
        public ?int $backup_minute = null,
        public ?int $bgwriter_delay = null,
        public ?int $bgwriter_flush_after = null,
        public ?int $bgwriter_lru_maxpages = null,
        public ?float $bgwriter_lru_multiplier = null,
        public ?int $deadlock_timeout = null,
        public ?string $default_toast_compression = null,
        public ?int $idle_in_transaction_session_timeout = null,
        public ?bool $jit = null,
        public ?int $log_autovacuum_min_duration = null,
        public ?string $log_error_verbosity = null,
        public ?string $log_line_prefix = null,
        public ?int $log_min_duration_statement = null,
        public ?int $max_connections = null,
        public ?int $max_failover_replication_time_lag = null,
        public ?int $max_files_per_process = null,
        public ?int $max_locks_per_transaction = null,
        public ?int $max_logical_replication_workers = null,
        public ?int $max_parallel_workers = null,
        public ?int $max_parallel_workers_per_gather = null,
        public ?int $max_pred_locks_per_transaction = null,
        public ?int $max_prepared_transactions = null,
        public ?int $max_replication_slots = null,
        public ?int $max_slot_wal_keep_size = null,
        public ?int $max_stack_depth = null,
        public ?int $max_standby_archive_delay = null,
        public ?int $max_standby_streaming_delay = null,
        public ?int $max_wal_senders = null,
        public ?int $max_worker_processes = null,
        #[WireName('pg_partman_bgw.interval')]
        public ?int $pgPartmanBgwInterval = null,
        #[WireName('pg_partman_bgw.role')]
        public ?string $pgPartmanBgwRole = null,
        #[WireName('pg_stat_statements.track')]
        public ?string $pgStatStatementsTrack = null,
        public ?PgbouncerAdvancedConfig $pgbouncer = null,
        public ?float $shared_buffers_percentage = null,
        public ?bool $stat_monitor_enable = null,
        public ?string $synchronous_replication = null,
        public ?int $temp_file_limit = null,
        public ?TimescaledbAdvancedConfig $timescaledb = null,
        public ?string $timezone = null,
        public ?int $track_activity_query_size = null,
        public ?string $track_commit_timestamp = null,
        public ?string $track_functions = null,
        public ?string $track_io_timing = null,
        public ?int $wal_sender_timeout = null,
        public ?int $wal_writer_delay = null,
        public ?int $work_mem = null,
    ) {
    }
}
