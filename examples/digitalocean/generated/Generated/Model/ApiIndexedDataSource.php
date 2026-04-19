<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiIndexedDataSourceStatus;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiIndexedDataSource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed_at' => ['completed_at', ['datetime', null]],
        'data_source_uuid' => ['data_source_uuid', null],
        'error_details' => ['error_details', null],
        'error_msg' => ['error_msg', null],
        'failed_item_count' => ['failed_item_count', null],
        'indexed_file_count' => ['indexed_file_count', null],
        'indexed_item_count' => ['indexed_item_count', null],
        'removed_item_count' => ['removed_item_count', null],
        'skipped_item_count' => ['skipped_item_count', null],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiIndexedDataSourceStatus::class]],
        'total_bytes' => ['total_bytes', null],
        'total_bytes_indexed' => ['total_bytes_indexed', null],
        'total_file_count' => ['total_file_count', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?string $data_source_uuid = null,
        public ?string $error_details = null,
        public ?string $error_msg = null,
        public ?string $failed_item_count = null,
        public ?string $indexed_file_count = null,
        public ?string $indexed_item_count = null,
        public ?string $removed_item_count = null,
        public ?string $skipped_item_count = null,
        public ?DateTimeImmutable $started_at = null,
        public ?ApiIndexedDataSourceStatus $status = null,
        public ?string $total_bytes = null,
        public ?string $total_bytes_indexed = null,
        public ?string $total_file_count = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'data_source_uuid' => $this->data_source_uuid,
            'error_details' => $this->error_details,
            'error_msg' => $this->error_msg,
            'failed_item_count' => $this->failed_item_count,
            'indexed_file_count' => $this->indexed_file_count,
            'indexed_item_count' => $this->indexed_item_count,
            'removed_item_count' => $this->removed_item_count,
            'skipped_item_count' => $this->skipped_item_count,
            'started_at' => $this->started_at?->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'total_bytes' => $this->total_bytes,
            'total_bytes_indexed' => $this->total_bytes_indexed,
            'total_file_count' => $this->total_file_count,
        ];
    }
}
