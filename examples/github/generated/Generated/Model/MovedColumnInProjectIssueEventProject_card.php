<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MovedColumnInProjectIssueEventProject_card
{
    public function __construct(
        public string $column_name,
        public int $id,
        public int $project_id,
        public string $project_url,
        public string $url,
        public ?string $previous_column_name = null,
    ) {
    }
}
