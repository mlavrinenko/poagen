<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProjectsV2IterationSetting
{
    public function __construct(
        public string $id,
        public string $title,
        public ?bool $completed = null,
        public ?float $duration = null,
        public ?string $start_date = null,
        public ?string $title_html = null,
    ) {
    }
}
