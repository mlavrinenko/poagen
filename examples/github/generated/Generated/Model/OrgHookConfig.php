<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrgHookConfig
{
    public function __construct(
        public ?string $content_type = null,
        public ?string $insecure_ssl = null,
        public ?string $secret = null,
        public ?string $url = null,
    ) {
    }
}
