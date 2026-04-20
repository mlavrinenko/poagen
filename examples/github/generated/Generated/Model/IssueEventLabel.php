<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class IssueEventLabel
{
    public function __construct(
        public ?string $color = null,
        public ?string $name = null,
    ) {
    }
}
