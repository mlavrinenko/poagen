<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRegistryPackagePublishedRegistry_packagePackage_versionRelease
{
    public function __construct(
        public ?WebhookRegistryPackagePublishedRegistry_packagePackage_versionReleaseAuthor $author = null,
        public ?string $created_at = null,
        public ?bool $draft = null,
        public ?string $html_url = null,
        public ?int $id = null,
        public ?string $name = null,
        public ?bool $prerelease = null,
        public ?string $published_at = null,
        public ?string $tag_name = null,
        public ?string $target_commitish = null,
        public ?string $url = null,
    ) {
    }
}
