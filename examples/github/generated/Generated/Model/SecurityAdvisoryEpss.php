<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecurityAdvisoryEpss
{
    public function __construct(
        public ?float $percentage = null,
        public ?float $percentile = null,
    ) {
    }
}
