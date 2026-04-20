<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProjectsV2FieldConfiguration
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\ProjectsV2IterationSettings> $iterations
     */
    public function __construct(
        public ?int $duration = null,
        public ?array $iterations = null,
        public ?int $start_day = null,
    ) {
    }
}
