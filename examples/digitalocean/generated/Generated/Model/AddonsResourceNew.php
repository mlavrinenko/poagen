<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AddonsResourceNew
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\AddonsResourceMetadata> $metadata
     */
    public function __construct(
        public string $app_slug,
        public array $metadata,
        public string $name,
        public string $plan_slug,
        public ?string $fleet_uuid = null,
        public ?int $linked_droplet_id = null,
    ) {
    }
}
