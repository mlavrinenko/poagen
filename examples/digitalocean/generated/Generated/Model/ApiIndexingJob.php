<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiBatchJobPhase;
use Acme\DigitalOcean\Generated\Enum\ApiIndexJobStatus;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiIndexingJob implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed_datasources' => ['completed_datasources', null],
        'created_at' => ['created_at', ['datetime', null]],
        'data_source_jobs' => [
            'data_source_jobs',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiIndexedDataSource::class],
        ],
        'data_source_uuids' => ['data_source_uuids', ['list', null]],
        'finished_at' => ['finished_at', ['datetime', null]],
        'is_report_available' => ['is_report_available', null],
        'knowledge_base_uuid' => ['knowledge_base_uuid', null],
        'phase' => ['phase', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiBatchJobPhase::class]],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiIndexJobStatus::class]],
        'tokens' => ['tokens', null],
        'total_datasources' => ['total_datasources', null],
        'total_tokens' => ['total_tokens', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uuid' => ['uuid', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiIndexedDataSource> $data_source_jobs
     * @param ?list<string> $data_source_uuids
     */
    public function __construct(
        public ?int $completed_datasources = null,
        public ?DateTimeImmutable $created_at = null,
        public ?array $data_source_jobs = null,
        public ?array $data_source_uuids = null,
        public ?DateTimeImmutable $finished_at = null,
        public ?bool $is_report_available = null,
        public ?string $knowledge_base_uuid = null,
        public ?ApiBatchJobPhase $phase = null,
        public ?DateTimeImmutable $started_at = null,
        public ?ApiIndexJobStatus $status = null,
        public ?int $tokens = null,
        public ?int $total_datasources = null,
        public ?string $total_tokens = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed_datasources' => $this->completed_datasources,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'data_source_jobs' => $this->data_source_jobs,
            'data_source_uuids' => $this->data_source_uuids,
            'finished_at' => $this->finished_at?->format(\DateTimeInterface::RFC3339),
            'is_report_available' => $this->is_report_available,
            'knowledge_base_uuid' => $this->knowledge_base_uuid,
            'phase' => $this->phase,
            'started_at' => $this->started_at?->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'tokens' => $this->tokens,
            'total_datasources' => $this->total_datasources,
            'total_tokens' => $this->total_tokens,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'uuid' => $this->uuid,
        ];
    }
}
