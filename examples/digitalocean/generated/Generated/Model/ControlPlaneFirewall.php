<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ControlPlaneFirewall
{
    /**
     * @param ?list<string> $allowed_addresses
     */
    public function __construct(
        public ?array $allowed_addresses = null,
        public ?bool $enabled = null,
    ) {
    }
}
