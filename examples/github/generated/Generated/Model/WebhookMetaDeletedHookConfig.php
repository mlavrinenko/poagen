<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMetaDeletedHookConfig
{
    public function __construct(
        public string $content_type,
        public string $insecure_ssl,
        public string $url,
        public ?string $secret = null,
    ) {
    }
}
