<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryAdvisoryCvss
{
    public function __construct(
        public ?float $score = null,
        public ?string $vector_string = null,
    ) {
    }
}
