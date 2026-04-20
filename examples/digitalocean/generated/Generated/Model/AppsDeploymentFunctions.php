<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsDeploymentFunctions
{
    public function __construct(
        public ?string $name = null,
        public ?string $namespace = null,
        public ?string $source_commit_hash = null,
    ) {
    }
}
