<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CvssSeveritiesCvss_v3
{
    public function __construct(
        public ?float $score = null,
        public ?string $vector_string = null,
    ) {
    }
}
