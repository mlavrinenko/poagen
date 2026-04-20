<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPackagePublishedPackagePackage_version
{
    /**
     * @param list<array<string, mixed>> $metadata
     * @param list<array<string, mixed>> $package_files
     * @param ?mixed $body
     * @param ?list<array<string, mixed>> $docker_metadata
     * @param ?list<array<string, mixed>> $nuget_metadata
     * @param ?list<\Acme\GitHub\Generated\Model\WebhookRubygemsMetadata> $rubygems_metadata
     */
    public function __construct(
        public string $description,
        public string $html_url,
        public int $id,
        public string $installation_command,
        public array $metadata,
        public string $name,
        public array $package_files,
        public string $summary,
        public string $version,
        public ?WebhookPackagePublishedPackagePackage_versionAuthor $author = null,
        public $body = null,
        public ?string $body_html = null,
        public ?WebhookPackagePublishedPackagePackage_versionContainer_metadata $container_metadata = null,
        public ?string $created_at = null,
        public ?array $docker_metadata = null,
        public ?bool $draft = null,
        public ?string $manifest = null,
        public ?WebhookPackagePublishedPackagePackage_versionNpm_metadata $npm_metadata = null,
        public ?array $nuget_metadata = null,
        public ?string $package_url = null,
        public ?bool $prerelease = null,
        public ?WebhookPackagePublishedPackagePackage_versionRelease $release = null,
        public ?array $rubygems_metadata = null,
        public ?string $source_url = null,
        public ?string $tag_name = null,
        public ?string $target_commitish = null,
        public ?string $target_oid = null,
        public ?string $updated_at = null,
    ) {
    }
}
