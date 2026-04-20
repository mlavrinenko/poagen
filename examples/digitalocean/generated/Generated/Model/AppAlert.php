<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppAlertPhase;

final readonly class AppAlert
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertEmail> $emails
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertSlackWebhook> $slack_webhooks
     */
    public function __construct(
        public ?string $component_name = null,
        public ?array $emails = null,
        public ?string $id = null,
        public ?AppAlertPhase $phase = null,
        public ?AppAlertProgress $progress = null,
        public ?array $slack_webhooks = null,
        public ?AppAlertSpec $spec = null,
    ) {
    }
}
