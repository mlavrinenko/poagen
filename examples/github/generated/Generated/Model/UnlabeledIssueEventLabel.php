<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class UnlabeledIssueEventLabel
{
    public function __construct(
        public string $color,
        public string $name,
    ) {
    }
}
