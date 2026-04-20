<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPackageUpdatedPackageRegistry
{
    public function __construct(
        public string $about_url,
        public string $name,
        public string $type,
        public string $url,
        public string $vendor,
    ) {
    }
}
