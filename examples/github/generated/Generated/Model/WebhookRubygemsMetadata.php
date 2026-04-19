<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRubygemsMetadata implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'commit_oid' => ['commit_oid', null],
        'dependencies' => ['dependencies', ['list', null]],
        'description' => ['description', null],
        'homepage' => ['homepage', null],
        'metadata' => ['metadata', null],
        'name' => ['name', null],
        'platform' => ['platform', null],
        'readme' => ['readme', null],
        'repo' => ['repo', null],
        'version_info' => ['version_info', \Acme\GitHub\Generated\Model\WebhookRubygemsMetadataVersion_info::class],
    ];

    /**
     * @param ?list<array<string, string>> $dependencies
     * @param ?array<string, string> $metadata
     */
    public function __construct(
        public ?string $commit_oid = null,
        public ?array $dependencies = null,
        public ?string $description = null,
        public ?string $homepage = null,
        public ?array $metadata = null,
        public ?string $name = null,
        public ?string $platform = null,
        public ?string $readme = null,
        public ?string $repo = null,
        public ?WebhookRubygemsMetadataVersion_info $version_info = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commit_oid' => $this->commit_oid,
            'dependencies' => $this->dependencies,
            'description' => $this->description,
            'homepage' => $this->homepage,
            'metadata' => $this->metadata,
            'name' => $this->name,
            'platform' => $this->platform,
            'readme' => $this->readme,
            'repo' => $this->repo,
            'version_info' => $this->version_info,
        ];
    }
}
