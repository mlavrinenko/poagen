<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsBitbucketSourceSpec
{
    public function __construct(
        public ?string $branch = null,
        public ?bool $deploy_on_push = null,
        public ?string $repo = null,
    ) {
    }
}
