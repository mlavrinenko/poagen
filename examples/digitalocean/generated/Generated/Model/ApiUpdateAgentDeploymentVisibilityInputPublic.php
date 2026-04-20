<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiDeploymentVisibility;

final readonly class ApiUpdateAgentDeploymentVisibilityInputPublic
{
    public function __construct(
        public ?string $uuid = null,
        public ?ApiDeploymentVisibility $visibility = null,
    ) {
    }
}
