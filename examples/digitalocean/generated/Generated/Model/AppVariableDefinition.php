<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppVariableDefinition
{
    public function __construct(
        public string $key,
        public ?string $scope = null,
        public ?string $type = null,
        public ?string $value = null,
    ) {
    }
}
