<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AssociatedResourceStatus
{
    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?DestroyedAssociatedResource $droplet = null,
        public ?int $failures = null,
        public ?AssociatedResourceStatusResources $resources = null,
    ) {
    }
}
