<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProjectsV2SingleSelectOptions
{
    public function __construct(
        public string $color,
        public ProjectsV2SingleSelectOptionsDescription $description,
        public string $id,
        public ProjectsV2SingleSelectOptionsName $name,
    ) {
    }
}
