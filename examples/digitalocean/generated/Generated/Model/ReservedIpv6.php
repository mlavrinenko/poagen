<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ReservedIpv6
{
    /**
     * @param ?mixed $droplet
     */
    public function __construct(
        public $droplet = null,
        public ?string $ip = null,
        public ?string $region_slug = null,
        public ?DateTimeImmutable $reserved_at = null,
    ) {
    }
}
