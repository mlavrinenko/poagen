<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ArtifactWorkflow_run
{
    public function __construct(
        public ?string $head_branch = null,
        public ?int $head_repository_id = null,
        public ?string $head_sha = null,
        public ?int $id = null,
        public ?int $repository_id = null,
    ) {
    }
}
