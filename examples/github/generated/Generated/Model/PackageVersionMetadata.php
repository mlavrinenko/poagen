<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PackageVersionMetadata implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'package_type' => ['package_type', null],
        'container' => ['container', \Acme\GitHub\Generated\Model\PackageVersionMetadataContainer::class],
        'docker' => ['docker', \Acme\GitHub\Generated\Model\PackageVersionMetadataDocker::class],
    ];

    public function __construct(
        public string $package_type,
        public ?PackageVersionMetadataContainer $container = null,
        public ?PackageVersionMetadataDocker $docker = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'package_type' => $this->package_type,
            'container' => $this->container,
            'docker' => $this->docker,
        ];
    }
}
