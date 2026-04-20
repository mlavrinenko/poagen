<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppRouteSpec
{
    public function __construct(
        public ?string $path = null,
        public ?bool $preserve_path_prefix = null,
    ) {
    }
}
