<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRegistryPackagePublishedRegistry_packagePackage_version
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
        public string $package_url,
        public string $summary,
        public string $version,
        public ?WebhookRegistryPackagePublishedRegistry_packagePackage_versionAuthor $author = null,
        public $body = null,
        public ?string $body_html = null,
        public ?WebhookRegistryPackagePublishedRegistry_packagePackage_versionContainer_metadata $container_metadata = null,
        public ?string $created_at = null,
        public ?array $docker_metadata = null,
        public ?bool $draft = null,
        public ?string $manifest = null,
        public ?WebhookRegistryPackagePublishedRegistry_packagePackage_versionNpm_metadata $npm_metadata = null,
        public ?array $nuget_metadata = null,
        public ?bool $prerelease = null,
        public ?WebhookRegistryPackagePublishedRegistry_packagePackage_versionRelease $release = null,
        public ?array $rubygems_metadata = null,
        public ?string $tag_name = null,
        public ?string $target_commitish = null,
        public ?string $target_oid = null,
        public ?string $updated_at = null,
    ) {
    }
}
