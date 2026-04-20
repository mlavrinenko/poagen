<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppJobInvocationTrigger
{
    public function __construct(
        public ?AppJobInvocationTriggerManual $manual = null,
        public ?AppJobInvocationTriggerScheduled $scheduled = null,
        public ?string $type = null,
    ) {
    }
}
