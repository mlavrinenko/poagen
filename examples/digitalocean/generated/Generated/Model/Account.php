<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Account
{
    public function __construct(
        public int $droplet_limit,
        public string $email,
        public bool $email_verified,
        public int $floating_ip_limit,
        public string $status,
        public string $status_message,
        public string $uuid,
        public ?string $name = null,
        public ?AccountTeam $team = null,
    ) {
    }
}
