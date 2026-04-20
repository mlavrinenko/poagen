<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KafkaTopicConfig
{
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
}
