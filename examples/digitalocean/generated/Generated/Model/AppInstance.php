<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppInstance
{
    public function __construct(
        public ?string $component_name = null,
        public ?string $component_type = null,
        public ?string $instance_alias = null,
        public ?string $instance_name = null,
    ) {
    }
}
