<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PackageVersionMetadata
{
    public function __construct(
        public string $package_type,
        public ?PackageVersionMetadataContainer $container = null,
        public ?PackageVersionMetadataDocker $docker = null,
    ) {
    }
}
