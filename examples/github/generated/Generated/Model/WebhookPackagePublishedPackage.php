<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPackagePublishedPackage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'description' => ['description', null],
        'ecosystem' => ['ecosystem', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'namespace' => ['namespace', null],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\WebhookPackagePublishedPackageOwner::class],
        'package_type' => ['package_type', null],
        'package_version' => [
            'package_version',
            \Acme\GitHub\Generated\Model\WebhookPackagePublishedPackagePackage_version::class,
        ],
        'registry' => ['registry', \Acme\GitHub\Generated\Model\WebhookPackagePublishedPackageRegistry::class],
        'updated_at' => ['updated_at', null],
    ];

    public function __construct(
        public ?string $created_at = null,
        public ?string $description = null,
        public string $ecosystem,
        public string $html_url,
        public int $id,
        public string $name,
        public string $namespace,
        public WebhookPackagePublishedPackageOwner $owner,
        public string $package_type,
        public WebhookPackagePublishedPackagePackage_version $package_version,
        public WebhookPackagePublishedPackageRegistry $registry,
        public ?string $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'description' => $this->description,
            'ecosystem' => $this->ecosystem,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'namespace' => $this->namespace,
            'owner' => $this->owner,
            'package_type' => $this->package_type,
            'package_version' => $this->package_version,
            'registry' => $this->registry,
            'updated_at' => $this->updated_at,
        ];
    }
}
