<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRegistryPackageUpdatedRegistry_package
{
    /**
     * @param ?mixed $description
     * @param ?array<string, mixed> $registry
     */
    public function __construct(
        public string $created_at,
        public $description = null,
        public string $ecosystem,
        public string $html_url,
        public int $id,
        public string $name,
        public string $namespace,
        public WebhookRegistryPackageUpdatedRegistry_packageOwner $owner,
        public string $package_type,
        public WebhookRegistryPackageUpdatedRegistry_packagePackage_version $package_version,
        public ?array $registry = null,
        public string $updated_at,
    ) {
    }
}
