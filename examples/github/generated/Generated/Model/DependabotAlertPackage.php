<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DependabotAlertPackage
{
    public function __construct(
        public string $ecosystem,
        public string $name,
    ) {
    }
}
