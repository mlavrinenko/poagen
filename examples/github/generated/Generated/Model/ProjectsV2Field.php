<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class ProjectsV2Field
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\ProjectsV2SingleSelectOptions> $options
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $data_type,
        public int $id,
        public string $name,
        public string $project_url,
        public DateTimeImmutable $updated_at,
        public ?ProjectsV2FieldConfiguration $configuration = null,
        public ?int $issue_field_id = null,
        public ?string $node_id = null,
        public ?array $options = null,
    ) {
    }
}
