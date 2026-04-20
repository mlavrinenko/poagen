<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPackagePublishedPackage
{
    public function __construct(
        public ?string $created_at = null,
        public ?string $description = null,
        public string $ecosystem,
        public string $html_url,
        public int $id,
        public string $name,
        public string $namespace,
        public WebhookPackagePublishedPackageOwner $owner,
        public string $package_type,
        public WebhookPackagePublishedPackagePackage_version $package_version,
        public WebhookPackagePublishedPackageRegistry $registry,
        public ?string $updated_at = null,
    ) {
    }
}
