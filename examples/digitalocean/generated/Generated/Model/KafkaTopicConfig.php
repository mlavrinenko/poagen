<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KafkaTopicConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cleanup_policy' => ['cleanup_policy', null],
        'compression_type' => ['compression_type', null],
        'delete_retention_ms' => ['delete_retention_ms', null],
        'file_delete_delay_ms' => ['file_delete_delay_ms', null],
        'flush_messages' => ['flush_messages', null],
        'flush_ms' => ['flush_ms', null],
        'index_interval_bytes' => ['index_interval_bytes', null],
        'max_compaction_lag_ms' => ['max_compaction_lag_ms', null],
        'max_message_bytes' => ['max_message_bytes', null],
        'message_down_conversion_enable' => ['message_down_conversion_enable', null],
        'message_format_version' => ['message_format_version', null],
        'message_timestamp_type' => ['message_timestamp_type', null],
        'min_cleanable_dirty_ratio' => ['min_cleanable_dirty_ratio', null],
        'min_compaction_lag_ms' => ['min_compaction_lag_ms', null],
        'min_insync_replicas' => ['min_insync_replicas', null],
        'preallocate' => ['preallocate', null],
        'retention_bytes' => ['retention_bytes', null],
        'retention_ms' => ['retention_ms', null],
        'segment_bytes' => ['segment_bytes', null],
        'segment_jitter_ms' => ['segment_jitter_ms', null],
        'segment_ms' => ['segment_ms', null],
    ];

    public function __construct(
        public ?string $cleanup_policy = null,
        public ?string $compression_type = null,
        public ?int $delete_retention_ms = null,
        public ?int $file_delete_delay_ms = null,
        public ?int $flush_messages = null,
        public ?int $flush_ms = null,
        public ?int $index_interval_bytes = null,
        public ?int $max_compaction_lag_ms = null,
        public ?int $max_message_bytes = null,
        public ?bool $message_down_conversion_enable = null,
        public ?string $message_format_version = null,
        public ?string $message_timestamp_type = null,
        public ?float $min_cleanable_dirty_ratio = null,
        public ?int $min_compaction_lag_ms = null,
        public ?int $min_insync_replicas = null,
        public ?bool $preallocate = null,
        public ?int $retention_bytes = null,
        public ?int $retention_ms = null,
        public ?int $segment_bytes = null,
        public ?int $segment_jitter_ms = null,
        public ?int $segment_ms = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cleanup_policy' => $this->cleanup_policy,
            'compression_type' => $this->compression_type,
            'delete_retention_ms' => $this->delete_retention_ms,
            'file_delete_delay_ms' => $this->file_delete_delay_ms,
            'flush_messages' => $this->flush_messages,
            'flush_ms' => $this->flush_ms,
            'index_interval_bytes' => $this->index_interval_bytes,
            'max_compaction_lag_ms' => $this->max_compaction_lag_ms,
            'max_message_bytes' => $this->max_message_bytes,
            'message_down_conversion_enable' => $this->message_down_conversion_enable,
            'message_format_version' => $this->message_format_version,
            'message_timestamp_type' => $this->message_timestamp_type,
            'min_cleanable_dirty_ratio' => $this->min_cleanable_dirty_ratio,
            'min_compaction_lag_ms' => $this->min_compaction_lag_ms,
            'min_insync_replicas' => $this->min_insync_replicas,
            'preallocate' => $this->preallocate,
            'retention_bytes' => $this->retention_bytes,
            'retention_ms' => $this->retention_ms,
            'segment_bytes' => $this->segment_bytes,
            'segment_jitter_ms' => $this->segment_jitter_ms,
            'segment_ms' => $this->segment_ms,
        ];
    }
}
