<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRegistryPackageUpdatedRegistry_packagePackage_version implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => [
            'author',
            \Acme\GitHub\Generated\Model\WebhookRegistryPackageUpdatedRegistry_packagePackage_versionAuthor::class,
        ],
        'body' => ['body', null],
        'body_html' => ['body_html', null],
        'created_at' => ['created_at', null],
        'description' => ['description', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'installation_command' => ['installation_command', null],
        'metadata' => ['metadata', ['list', null]],
        'name' => ['name', null],
        'package_files' => ['package_files', ['list', null]],
        'package_url' => ['package_url', null],
        'summary' => ['summary', null],
        'target_commitish' => ['target_commitish', null],
        'target_oid' => ['target_oid', null],
        'updated_at' => ['updated_at', null],
        'version' => ['version', null],
        'docker_metadata' => ['docker_metadata', ['list', null]],
        'draft' => ['draft', null],
        'manifest' => ['manifest', null],
        'prerelease' => ['prerelease', null],
        'release' => [
            'release',
            \Acme\GitHub\Generated\Model\WebhookRegistryPackageUpdatedRegistry_packagePackage_versionRelease::class,
        ],
        'rubygems_metadata' => ['rubygems_metadata', ['list', \Acme\GitHub\Generated\Model\WebhookRubygemsMetadata::class]],
        'tag_name' => ['tag_name', null],
    ];

    /**
     * @param list<array<string, mixed>> $metadata
     * @param list<array<string, mixed>> $package_files
     * @param ?list<array<string, mixed>> $docker_metadata
     * @param ?list<\Acme\GitHub\Generated\Model\WebhookRubygemsMetadata> $rubygems_metadata
     */
    public function __construct(
        public WebhookRegistryPackageUpdatedRegistry_packagePackage_versionAuthor $author,
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
        public string $package_url,
        public string $summary,
        public string $target_commitish,
        public string $target_oid,
        public string $updated_at,
        public string $version,
        public ?array $docker_metadata = null,
        public ?bool $draft = null,
        public ?string $manifest = null,
        public ?bool $prerelease = null,
        public ?WebhookRegistryPackageUpdatedRegistry_packagePackage_versionRelease $release = null,
        public ?array $rubygems_metadata = null,
        public ?string $tag_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'body' => $this->body,
            'body_html' => $this->body_html,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'installation_command' => $this->installation_command,
            'metadata' => $this->metadata,
            'name' => $this->name,
            'package_files' => $this->package_files,
            'package_url' => $this->package_url,
            'summary' => $this->summary,
            'target_commitish' => $this->target_commitish,
            'target_oid' => $this->target_oid,
            'updated_at' => $this->updated_at,
            'version' => $this->version,
            'docker_metadata' => $this->docker_metadata,
            'draft' => $this->draft,
            'manifest' => $this->manifest,
            'prerelease' => $this->prerelease,
            'release' => $this->release,
            'rubygems_metadata' => $this->rubygems_metadata,
            'tag_name' => $this->tag_name,
        ];
    }
}
