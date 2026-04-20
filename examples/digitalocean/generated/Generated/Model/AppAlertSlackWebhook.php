<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppAlertSlackWebhook
{
    public function __construct(
        public ?string $channel = null,
        public ?string $url = null,
    ) {
    }
}
