<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiDeploymentStatus;
use Acme\DigitalOcean\Generated\Enum\ApiDeploymentVisibility;
use DateTimeImmutable;

final readonly class ApiDeployment
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $name = null,
        public ?ApiDeploymentStatus $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
        public ?string $uuid = null,
        public ?ApiDeploymentVisibility $visibility = null,
    ) {
    }
}
