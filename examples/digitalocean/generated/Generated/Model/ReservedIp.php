<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ReservedIp
{
    /**
     * @param ?mixed $droplet
     * @param ?mixed $region
     */
    public function __construct(
        public $droplet = null,
        public ?string $ip = null,
        public ?bool $locked = null,
        public ?string $project_id = null,
        public $region = null,
    ) {
    }
}
