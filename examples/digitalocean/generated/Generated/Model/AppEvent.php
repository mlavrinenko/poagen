<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AppEvent
{
    public function __construct(
        public ?AppEventAutoscaling $autoscaling = null,
        public ?DateTimeImmutable $created_at = null,
        public ?AppsDeployment $deployment = null,
        public ?string $deployment_id = null,
        public ?string $id = null,
        public ?string $type = null,
    ) {
    }
}
