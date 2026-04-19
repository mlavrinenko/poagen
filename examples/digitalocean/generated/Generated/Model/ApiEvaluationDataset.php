<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiEvaluationDataset implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'dataset_name' => ['dataset_name', null],
        'dataset_uuid' => ['dataset_uuid', null],
        'file_size' => ['file_size', null],
        'has_ground_truth' => ['has_ground_truth', null],
        'row_count' => ['row_count', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $dataset_name = null,
        public ?string $dataset_uuid = null,
        public ?string $file_size = null,
        public ?bool $has_ground_truth = null,
        public ?int $row_count = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'dataset_name' => $this->dataset_name,
            'dataset_uuid' => $this->dataset_uuid,
            'file_size' => $this->file_size,
            'has_ground_truth' => $this->has_ground_truth,
            'row_count' => $this->row_count,
        ];
    }
}
