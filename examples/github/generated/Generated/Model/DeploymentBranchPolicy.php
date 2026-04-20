<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DeploymentBranchPolicy
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $node_id = null,
        public ?string $type = null,
    ) {
    }
}
