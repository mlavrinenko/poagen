<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProjectsV2SingleSelectOption
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $color = null,
        public ?string $description = null,
    ) {
    }
}
