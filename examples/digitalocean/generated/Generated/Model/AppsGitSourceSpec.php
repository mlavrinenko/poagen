<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsGitSourceSpec
{
    public function __construct(
        public ?string $branch = null,
        public ?string $repo_clone_url = null,
    ) {
    }
}
