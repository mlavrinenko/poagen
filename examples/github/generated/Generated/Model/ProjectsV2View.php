<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class ProjectsV2View
{
    /**
     * @param mixed $creator
     * @param list<int> $group_by
     * @param list<list<mixed>> $sort_by
     * @param list<int> $vertical_group_by
     * @param list<int> $visible_fields
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public $creator,
        public array $group_by,
        public string $html_url,
        public int $id,
        public string $layout,
        public string $name,
        public string $node_id,
        public int $number,
        public string $project_url,
        public array $sort_by,
        public DateTimeImmutable $updated_at,
        public array $vertical_group_by,
        public array $visible_fields,
        public ?string $filter = null,
    ) {
    }
}
