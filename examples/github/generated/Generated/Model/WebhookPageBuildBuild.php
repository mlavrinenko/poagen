<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPageBuildBuild
{
    public function __construct(
        public ?string $commit = null,
        public string $created_at,
        public int $duration,
        public WebhookPageBuildBuildError $error,
        public WebhookPageBuildBuildPusher $pusher,
        public string $status,
        public string $updated_at,
        public string $url,
    ) {
    }
}
