<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Dependency
{
    /**
     * @param ?list<string> $dependencies
     */
    public function __construct(
        public ?array $dependencies = null,
        public ?Metadata $metadata = null,
        public ?string $package_url = null,
        public ?string $relationship = null,
        public ?string $scope = null,
    ) {
    }
}
