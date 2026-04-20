<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RunnerLabel
{
    public function __construct(
        public string $name,
        public ?int $id = null,
        public ?string $type = null,
    ) {
    }
}
