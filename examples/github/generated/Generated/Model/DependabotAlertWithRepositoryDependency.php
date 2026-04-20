<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DependabotAlertWithRepositoryDependency
{
    public function __construct(
        public ?string $manifest_path = null,
        public ?DependabotAlertPackage $package = null,
        public ?string $relationship = null,
        public ?string $scope = null,
    ) {
    }
}
