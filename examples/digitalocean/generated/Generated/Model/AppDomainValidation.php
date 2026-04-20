<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppDomainValidation
{
    public function __construct(
        public ?string $txt_name = null,
        public ?string $txt_value = null,
    ) {
    }
}
