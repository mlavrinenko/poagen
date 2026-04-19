<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRegistryPackagePublishedRegistry_packagePackage_version implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'installation_command' => ['installation_command', null],
        'metadata' => ['metadata', ['list', null]],
        'name' => ['name', null],
        'package_files' => ['package_files', ['list', null]],
        'package_url' => ['package_url', null],
        'summary' => ['summary', null],
        'version' => ['version', null],
        'author' => [
            'author',
            \Acme\GitHub\Generated\Model\WebhookRegistryPackagePublishedRegistry_packagePackage_versionAuthor::class,
        ],
        'body' => ['body', null],
        'body_html' => ['body_html', null],
        'container_metadata' => [
            'container_metadata',
            \Acme\GitHub\Generated\Model\WebhookRegistryPackagePublishedRegistry_packagePackage_versionContainer_metadata::class,
        ],
        'created_at' => ['created_at', null],
        'docker_metadata' => ['docker_metadata', ['list', null]],
        'draft' => ['draft', null],
        'manifest' => ['manifest', null],
        'npm_metadata' => [
            'npm_metadata',
            \Acme\GitHub\Generated\Model\WebhookRegistryPackagePublishedRegistry_packagePackage_versionNpm_metadata::class,
        ],
        'nuget_metadata' => ['nuget_metadata', ['list', null]],
        'prerelease' => ['prerelease', null],
        'release' => [
            'release',
            \Acme\GitHub\Generated\Model\WebhookRegistryPackagePublishedRegistry_packagePackage_versionRelease::class,
        ],
        'rubygems_metadata' => ['rubygems_metadata', ['list', \Acme\GitHub\Generated\Model\WebhookRubygemsMetadata::class]],
        'tag_name' => ['tag_name', null],
        'target_commitish' => ['target_commitish', null],
        'target_oid' => ['target_oid', null],
        'updated_at' => ['updated_at', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'installation_command' => $this->installation_command,
            'metadata' => $this->metadata,
            'name' => $this->name,
            'package_files' => $this->package_files,
            'package_url' => $this->package_url,
            'summary' => $this->summary,
            'version' => $this->version,
            'author' => $this->author,
            'body' => $this->body,
            'body_html' => $this->body_html,
            'container_metadata' => $this->container_metadata,
            'created_at' => $this->created_at,
            'docker_metadata' => $this->docker_metadata,
            'draft' => $this->draft,
            'manifest' => $this->manifest,
            'npm_metadata' => $this->npm_metadata,
            'nuget_metadata' => $this->nuget_metadata,
            'prerelease' => $this->prerelease,
            'release' => $this->release,
            'rubygems_metadata' => $this->rubygems_metadata,
            'tag_name' => $this->tag_name,
            'target_commitish' => $this->target_commitish,
            'target_oid' => $this->target_oid,
            'updated_at' => $this->updated_at,
        ];
    }
}
