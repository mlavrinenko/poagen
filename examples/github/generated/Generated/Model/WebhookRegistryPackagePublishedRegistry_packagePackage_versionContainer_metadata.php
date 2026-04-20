<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRegistryPackagePublishedRegistry_packagePackage_versionContainer_metadata
{
    /**
     * @param ?array<string, mixed> $labels
     * @param ?array<string, mixed> $manifest
     */
    public function __construct(
        public ?array $labels = null,
        public ?array $manifest = null,
        public ?WebhookRegistryPackagePublishedRegistry_packagePackage_versionContainer_metadataTag $tag = null,
    ) {
    }
}
