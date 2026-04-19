<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRegistryPackageUpdatedRegistry_package implements JsonSerializable
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
        'owner' => ['owner', \Acme\GitHub\Generated\Model\WebhookRegistryPackageUpdatedRegistry_packageOwner::class],
        'package_type' => ['package_type', null],
        'package_version' => [
            'package_version',
            \Acme\GitHub\Generated\Model\WebhookRegistryPackageUpdatedRegistry_packagePackage_version::class,
        ],
        'registry' => ['registry', null],
        'updated_at' => ['updated_at', null],
    ];

    /**
     * @param ?mixed $description
     * @param ?array<string, mixed> $registry
     */
    public function __construct(
        public string $created_at,
        public $description = null,
        public string $ecosystem,
        public string $html_url,
        public int $id,
        public string $name,
        public string $namespace,
        public WebhookRegistryPackageUpdatedRegistry_packageOwner $owner,
        public string $package_type,
        public WebhookRegistryPackageUpdatedRegistry_packagePackage_version $package_version,
        public ?array $registry = null,
        public string $updated_at,
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
