<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppJobInvocationTriggerManualUser
{
    public function __construct(
        public ?string $email = null,
        public ?string $full_name = null,
        public ?string $uuid = null,
    ) {
    }
}
