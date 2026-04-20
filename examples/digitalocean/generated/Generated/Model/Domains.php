<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Domains
{
    public function __construct(
        public ?string $certificate_id = null,
        public ?bool $is_managed = null,
        public ?string $name = null,
    ) {
    }
}
