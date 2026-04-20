<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsDeploymentStaticSite
{
    public function __construct(
        public ?string $name = null,
        public ?string $source_commit_hash = null,
    ) {
    }
}
