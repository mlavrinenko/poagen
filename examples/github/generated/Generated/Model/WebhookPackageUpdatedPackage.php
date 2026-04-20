<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPackageUpdatedPackage
{
    public function __construct(
        public string $created_at,
        public ?string $description = null,
        public string $ecosystem,
        public string $html_url,
        public int $id,
        public string $name,
        public string $namespace,
        public WebhookPackageUpdatedPackageOwner $owner,
        public string $package_type,
        public WebhookPackageUpdatedPackagePackage_version $package_version,
        public WebhookPackageUpdatedPackageRegistry $registry,
        public string $updated_at,
    ) {
    }
}
