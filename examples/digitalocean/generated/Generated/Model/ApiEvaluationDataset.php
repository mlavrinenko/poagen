<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiEvaluationDataset
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $dataset_name = null,
        public ?string $dataset_uuid = null,
        public ?string $file_size = null,
        public ?bool $has_ground_truth = null,
        public ?int $row_count = null,
    ) {
    }
}
