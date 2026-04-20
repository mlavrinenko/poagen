<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CreateNamespace
{
    public function __construct(
        public string $label,
        public string $region,
    ) {
    }
}
