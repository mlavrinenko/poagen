<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPackagePublishedPackagePackage_versionRelease
{
    public function __construct(
        public WebhookPackagePublishedPackagePackage_versionReleaseAuthor $author,
        public string $created_at,
        public bool $draft,
        public string $html_url,
        public int $id,
        public ?string $name = null,
        public bool $prerelease,
        public string $published_at,
        public string $tag_name,
        public string $target_commitish,
        public string $url,
    ) {
    }
}
