<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsImageSourceSpec
{
    public function __construct(
        public ?AppsImageSourceSpecDeploy_on_push $deploy_on_push = null,
        public ?string $digest = null,
        public ?string $registry = null,
        public ?string $registry_credentials = null,
        public ?string $registry_type = null,
        public ?string $repository = null,
        public ?string $tag = null,
    ) {
    }
}
