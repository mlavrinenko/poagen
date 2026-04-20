<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPackageUpdatedPackagePackage_version
{
    /**
     * @param list<array<string, mixed>> $metadata
     * @param list<array<string, mixed>> $package_files
     * @param ?list<array<string, mixed>> $docker_metadata
     * @param ?list<\Acme\GitHub\Generated\Model\WebhookRubygemsMetadata> $rubygems_metadata
     */
    public function __construct(
        public WebhookPackageUpdatedPackagePackage_versionAuthor $author,
        public string $body,
        public string $body_html,
        public string $created_at,
        public string $description,
        public string $html_url,
        public int $id,
        public string $installation_command,
        public array $metadata,
        public string $name,
        public array $package_files,
        public string $summary,
        public string $target_commitish,
        public string $target_oid,
        public string $updated_at,
        public string $version,
        public ?array $docker_metadata = null,
        public ?bool $draft = null,
        public ?string $manifest = null,
        public ?string $package_url = null,
        public ?bool $prerelease = null,
        public ?WebhookPackageUpdatedPackagePackage_versionRelease $release = null,
        public ?array $rubygems_metadata = null,
        public ?string $source_url = null,
        public ?string $tag_name = null,
    ) {
    }
}
