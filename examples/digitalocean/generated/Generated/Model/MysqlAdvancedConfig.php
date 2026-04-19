<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class MysqlAdvancedConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'backup_hour' => ['backup_hour', null],
        'backup_minute' => ['backup_minute', null],
        'binlog_retention_period' => ['binlog_retention_period', null],
        'connect_timeout' => ['connect_timeout', null],
        'default_time_zone' => ['default_time_zone', null],
        'group_concat_max_len' => ['group_concat_max_len', null],
        'information_schema_stats_expiry' => ['information_schema_stats_expiry', null],
        'innodb_change_buffer_max_size' => ['innodb_change_buffer_max_size', null],
        'innodb_flush_neighbors' => ['innodb_flush_neighbors', null],
        'innodb_ft_min_token_size' => ['innodb_ft_min_token_size', null],
        'innodb_ft_server_stopword_table' => ['innodb_ft_server_stopword_table', null],
        'innodb_lock_wait_timeout' => ['innodb_lock_wait_timeout', null],
        'innodb_log_buffer_size' => ['innodb_log_buffer_size', null],
        'innodb_online_alter_log_max_size' => ['innodb_online_alter_log_max_size', null],
        'innodb_print_all_deadlocks' => ['innodb_print_all_deadlocks', null],
        'innodb_read_io_threads' => ['innodb_read_io_threads', null],
        'innodb_rollback_on_timeout' => ['innodb_rollback_on_timeout', null],
        'innodb_thread_concurrency' => ['innodb_thread_concurrency', null],
        'innodb_write_io_threads' => ['innodb_write_io_threads', null],
        'interactive_timeout' => ['interactive_timeout', null],
        'internal_tmp_mem_storage_engine' => ['internal_tmp_mem_storage_engine', null],
        'log_output' => ['log_output', null],
        'long_query_time' => ['long_query_time', null],
        'max_allowed_packet' => ['max_allowed_packet', null],
        'max_heap_table_size' => ['max_heap_table_size', null],
        'mysql_incremental_backup' => [
            'mysql_incremental_backup',
            \Acme\DigitalOcean\Generated\Model\MysqlIncrementalBackup::class,
        ],
        'net_buffer_length' => ['net_buffer_length', null],
        'net_read_timeout' => ['net_read_timeout', null],
        'net_write_timeout' => ['net_write_timeout', null],
        'slow_query_log' => ['slow_query_log', null],
        'sort_buffer_size' => ['sort_buffer_size', null],
        'sql_mode' => ['sql_mode', null],
        'sql_require_primary_key' => ['sql_require_primary_key', null],
        'tmp_table_size' => ['tmp_table_size', null],
        'wait_timeout' => ['wait_timeout', null],
    ];

    public function __construct(
        public ?int $backup_hour = null,
        public ?int $backup_minute = null,
        public ?float $binlog_retention_period = null,
        public ?int $connect_timeout = null,
        public ?string $default_time_zone = null,
        public ?int $group_concat_max_len = null,
        public ?int $information_schema_stats_expiry = null,
        public ?int $innodb_change_buffer_max_size = null,
        public ?int $innodb_flush_neighbors = null,
        public ?int $innodb_ft_min_token_size = null,
        public ?string $innodb_ft_server_stopword_table = null,
        public ?int $innodb_lock_wait_timeout = null,
        public ?int $innodb_log_buffer_size = null,
        public ?int $innodb_online_alter_log_max_size = null,
        public ?bool $innodb_print_all_deadlocks = null,
        public ?int $innodb_read_io_threads = null,
        public ?bool $innodb_rollback_on_timeout = null,
        public ?int $innodb_thread_concurrency = null,
        public ?int $innodb_write_io_threads = null,
        public ?int $interactive_timeout = null,
        public ?string $internal_tmp_mem_storage_engine = null,
        public ?string $log_output = null,
        public ?float $long_query_time = null,
        public ?int $max_allowed_packet = null,
        public ?int $max_heap_table_size = null,
        public ?MysqlIncrementalBackup $mysql_incremental_backup = null,
        public ?int $net_buffer_length = null,
        public ?int $net_read_timeout = null,
        public ?int $net_write_timeout = null,
        public ?bool $slow_query_log = null,
        public ?int $sort_buffer_size = null,
        public ?string $sql_mode = null,
        public ?bool $sql_require_primary_key = null,
        public ?int $tmp_table_size = null,
        public ?int $wait_timeout = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'backup_hour' => $this->backup_hour,
            'backup_minute' => $this->backup_minute,
            'binlog_retention_period' => $this->binlog_retention_period,
            'connect_timeout' => $this->connect_timeout,
            'default_time_zone' => $this->default_time_zone,
            'group_concat_max_len' => $this->group_concat_max_len,
            'information_schema_stats_expiry' => $this->information_schema_stats_expiry,
            'innodb_change_buffer_max_size' => $this->innodb_change_buffer_max_size,
            'innodb_flush_neighbors' => $this->innodb_flush_neighbors,
            'innodb_ft_min_token_size' => $this->innodb_ft_min_token_size,
            'innodb_ft_server_stopword_table' => $this->innodb_ft_server_stopword_table,
            'innodb_lock_wait_timeout' => $this->innodb_lock_wait_timeout,
            'innodb_log_buffer_size' => $this->innodb_log_buffer_size,
            'innodb_online_alter_log_max_size' => $this->innodb_online_alter_log_max_size,
            'innodb_print_all_deadlocks' => $this->innodb_print_all_deadlocks,
            'innodb_read_io_threads' => $this->innodb_read_io_threads,
            'innodb_rollback_on_timeout' => $this->innodb_rollback_on_timeout,
            'innodb_thread_concurrency' => $this->innodb_thread_concurrency,
            'innodb_write_io_threads' => $this->innodb_write_io_threads,
            'interactive_timeout' => $this->interactive_timeout,
            'internal_tmp_mem_storage_engine' => $this->internal_tmp_mem_storage_engine,
            'log_output' => $this->log_output,
            'long_query_time' => $this->long_query_time,
            'max_allowed_packet' => $this->max_allowed_packet,
            'max_heap_table_size' => $this->max_heap_table_size,
            'mysql_incremental_backup' => $this->mysql_incremental_backup,
            'net_buffer_length' => $this->net_buffer_length,
            'net_read_timeout' => $this->net_read_timeout,
            'net_write_timeout' => $this->net_write_timeout,
            'slow_query_log' => $this->slow_query_log,
            'sort_buffer_size' => $this->sort_buffer_size,
            'sql_mode' => $this->sql_mode,
            'sql_require_primary_key' => $this->sql_require_primary_key,
            'tmp_table_size' => $this->tmp_table_size,
            'wait_timeout' => $this->wait_timeout,
        ];
    }
}
