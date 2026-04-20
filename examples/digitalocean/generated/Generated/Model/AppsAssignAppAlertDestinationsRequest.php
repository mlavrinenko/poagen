<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsAssignAppAlertDestinationsRequest
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertEmail> $emails
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertSlackWebhook> $slack_webhooks
     */
    public function __construct(
        public ?array $emails = null,
        public ?array $slack_webhooks = null,
    ) {
    }
}
