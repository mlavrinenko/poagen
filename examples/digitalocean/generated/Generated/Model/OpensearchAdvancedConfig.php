<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class OpensearchAdvancedConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action_auto_create_index_enabled' => ['action_auto_create_index_enabled', null],
        'action_destructive_requires_name' => ['action_destructive_requires_name', null],
        'cluster_max_shards_per_node' => ['cluster_max_shards_per_node', null],
        'cluster_routing_allocation_node_concurrent_recoveries' => [
            'cluster_routing_allocation_node_concurrent_recoveries',
            null,
        ],
        'enable_security_audit' => ['enable_security_audit', null],
        'http_max_content_length_bytes' => ['http_max_content_length_bytes', null],
        'http_max_header_size_bytes' => ['http_max_header_size_bytes', null],
        'http_max_initial_line_length_bytes' => ['http_max_initial_line_length_bytes', null],
        'indices_fielddata_cache_size_percentage' => ['indices_fielddata_cache_size_percentage', null],
        'indices_memory_index_buffer_size_percentage' => ['indices_memory_index_buffer_size_percentage', null],
        'indices_memory_max_index_buffer_size_mb' => ['indices_memory_max_index_buffer_size_mb', null],
        'indices_memory_min_index_buffer_size_mb' => ['indices_memory_min_index_buffer_size_mb', null],
        'indices_queries_cache_size_percentage' => ['indices_queries_cache_size_percentage', null],
        'indices_query_bool_max_clause_count' => ['indices_query_bool_max_clause_count', null],
        'indices_recovery_max_concurrent_file_chunks' => ['indices_recovery_max_concurrent_file_chunks', null],
        'indices_recovery_max_mb_per_sec' => ['indices_recovery_max_mb_per_sec', null],
        'ism_enabled' => ['ism_enabled', null],
        'ism_history_enabled' => ['ism_history_enabled', null],
        'ism_history_max_age_hours' => ['ism_history_max_age_hours', null],
        'ism_history_max_docs' => ['ism_history_max_docs', null],
        'ism_history_rollover_check_period_hours' => ['ism_history_rollover_check_period_hours', null],
        'ism_history_rollover_retention_period_days' => ['ism_history_rollover_retention_period_days', null],
        'keep_index_refresh_interval' => ['keep_index_refresh_interval', null],
        'knn_memory_circuit_breaker_enabled' => ['knn_memory_circuit_breaker_enabled', null],
        'knn_memory_circuit_breaker_limit' => ['knn_memory_circuit_breaker_limit', null],
        'override_main_response_version' => ['override_main_response_version', null],
        'plugins_alerting_filter_by_backend_roles_enabled' => ['plugins_alerting_filter_by_backend_roles_enabled', null],
        'reindex_remote_whitelist' => ['reindex_remote_whitelist', ['list', null]],
        'script_max_compilations_rate' => ['script_max_compilations_rate', null],
        'search_max_buckets' => ['search_max_buckets', null],
        'thread_pool_analyze_queue_size' => ['thread_pool_analyze_queue_size', null],
        'thread_pool_analyze_size' => ['thread_pool_analyze_size', null],
        'thread_pool_force_merge_size' => ['thread_pool_force_merge_size', null],
        'thread_pool_get_queue_size' => ['thread_pool_get_queue_size', null],
        'thread_pool_get_size' => ['thread_pool_get_size', null],
        'thread_pool_search_queue_size' => ['thread_pool_search_queue_size', null],
        'thread_pool_search_size' => ['thread_pool_search_size', null],
        'thread_pool_search_throttled_queue_size' => ['thread_pool_search_throttled_queue_size', null],
        'thread_pool_search_throttled_size' => ['thread_pool_search_throttled_size', null],
        'thread_pool_write_queue_size' => ['thread_pool_write_queue_size', null],
        'thread_pool_write_size' => ['thread_pool_write_size', null],
    ];

    /**
     * @param ?list<string> $reindex_remote_whitelist
     */
    public function __construct(
        public ?bool $action_auto_create_index_enabled = null,
        public ?bool $action_destructive_requires_name = null,
        public ?int $cluster_max_shards_per_node = null,
        public ?int $cluster_routing_allocation_node_concurrent_recoveries = null,
        public ?bool $enable_security_audit = null,
        public ?int $http_max_content_length_bytes = null,
        public ?int $http_max_header_size_bytes = null,
        public ?int $http_max_initial_line_length_bytes = null,
        public ?int $indices_fielddata_cache_size_percentage = null,
        public ?int $indices_memory_index_buffer_size_percentage = null,
        public ?int $indices_memory_max_index_buffer_size_mb = null,
        public ?int $indices_memory_min_index_buffer_size_mb = null,
        public ?int $indices_queries_cache_size_percentage = null,
        public ?int $indices_query_bool_max_clause_count = null,
        public ?int $indices_recovery_max_concurrent_file_chunks = null,
        public ?int $indices_recovery_max_mb_per_sec = null,
        public ?bool $ism_enabled = null,
        public ?bool $ism_history_enabled = null,
        public ?int $ism_history_max_age_hours = null,
        public ?int $ism_history_max_docs = null,
        public ?int $ism_history_rollover_check_period_hours = null,
        public ?int $ism_history_rollover_retention_period_days = null,
        public ?bool $keep_index_refresh_interval = null,
        public ?bool $knn_memory_circuit_breaker_enabled = null,
        public ?int $knn_memory_circuit_breaker_limit = null,
        public ?bool $override_main_response_version = null,
        public ?bool $plugins_alerting_filter_by_backend_roles_enabled = null,
        public ?array $reindex_remote_whitelist = null,
        public ?string $script_max_compilations_rate = null,
        public ?int $search_max_buckets = null,
        public ?int $thread_pool_analyze_queue_size = null,
        public ?int $thread_pool_analyze_size = null,
        public ?int $thread_pool_force_merge_size = null,
        public ?int $thread_pool_get_queue_size = null,
        public ?int $thread_pool_get_size = null,
        public ?int $thread_pool_search_queue_size = null,
        public ?int $thread_pool_search_size = null,
        public ?int $thread_pool_search_throttled_queue_size = null,
        public ?int $thread_pool_search_throttled_size = null,
        public ?int $thread_pool_write_queue_size = null,
        public ?int $thread_pool_write_size = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action_auto_create_index_enabled' => $this->action_auto_create_index_enabled,
            'action_destructive_requires_name' => $this->action_destructive_requires_name,
            'cluster_max_shards_per_node' => $this->cluster_max_shards_per_node,
            'cluster_routing_allocation_node_concurrent_recoveries' => $this->cluster_routing_allocation_node_concurrent_recoveries,
            'enable_security_audit' => $this->enable_security_audit,
            'http_max_content_length_bytes' => $this->http_max_content_length_bytes,
            'http_max_header_size_bytes' => $this->http_max_header_size_bytes,
            'http_max_initial_line_length_bytes' => $this->http_max_initial_line_length_bytes,
            'indices_fielddata_cache_size_percentage' => $this->indices_fielddata_cache_size_percentage,
            'indices_memory_index_buffer_size_percentage' => $this->indices_memory_index_buffer_size_percentage,
            'indices_memory_max_index_buffer_size_mb' => $this->indices_memory_max_index_buffer_size_mb,
            'indices_memory_min_index_buffer_size_mb' => $this->indices_memory_min_index_buffer_size_mb,
            'indices_queries_cache_size_percentage' => $this->indices_queries_cache_size_percentage,
            'indices_query_bool_max_clause_count' => $this->indices_query_bool_max_clause_count,
            'indices_recovery_max_concurrent_file_chunks' => $this->indices_recovery_max_concurrent_file_chunks,
            'indices_recovery_max_mb_per_sec' => $this->indices_recovery_max_mb_per_sec,
            'ism_enabled' => $this->ism_enabled,
            'ism_history_enabled' => $this->ism_history_enabled,
            'ism_history_max_age_hours' => $this->ism_history_max_age_hours,
            'ism_history_max_docs' => $this->ism_history_max_docs,
            'ism_history_rollover_check_period_hours' => $this->ism_history_rollover_check_period_hours,
            'ism_history_rollover_retention_period_days' => $this->ism_history_rollover_retention_period_days,
            'keep_index_refresh_interval' => $this->keep_index_refresh_interval,
            'knn_memory_circuit_breaker_enabled' => $this->knn_memory_circuit_breaker_enabled,
            'knn_memory_circuit_breaker_limit' => $this->knn_memory_circuit_breaker_limit,
            'override_main_response_version' => $this->override_main_response_version,
            'plugins_alerting_filter_by_backend_roles_enabled' => $this->plugins_alerting_filter_by_backend_roles_enabled,
            'reindex_remote_whitelist' => $this->reindex_remote_whitelist,
            'script_max_compilations_rate' => $this->script_max_compilations_rate,
            'search_max_buckets' => $this->search_max_buckets,
            'thread_pool_analyze_queue_size' => $this->thread_pool_analyze_queue_size,
            'thread_pool_analyze_size' => $this->thread_pool_analyze_size,
            'thread_pool_force_merge_size' => $this->thread_pool_force_merge_size,
            'thread_pool_get_queue_size' => $this->thread_pool_get_queue_size,
            'thread_pool_get_size' => $this->thread_pool_get_size,
            'thread_pool_search_queue_size' => $this->thread_pool_search_queue_size,
            'thread_pool_search_size' => $this->thread_pool_search_size,
            'thread_pool_search_throttled_queue_size' => $this->thread_pool_search_throttled_queue_size,
            'thread_pool_search_throttled_size' => $this->thread_pool_search_throttled_size,
            'thread_pool_write_queue_size' => $this->thread_pool_write_queue_size,
            'thread_pool_write_size' => $this->thread_pool_write_size,
        ];
    }
}
