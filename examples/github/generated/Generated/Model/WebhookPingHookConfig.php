<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPingHookConfig
{
    public function __construct(
        public ?WebhookConfigContentType $content_type = null,
        public ?WebhookConfigInsecureSsl $insecure_ssl = null,
        public ?WebhookConfigSecret $secret = null,
        public ?WebhookConfigUrl $url = null,
    ) {
    }
}
