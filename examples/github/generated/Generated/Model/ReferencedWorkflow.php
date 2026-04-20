<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReferencedWorkflow
{
    public function __construct(
        public string $path,
        public string $sha,
        public ?string $ref = null,
    ) {
    }
}
