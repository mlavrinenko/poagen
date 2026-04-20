<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiModelVersion
{
    public function __construct(
        public ?int $major = null,
        public ?int $minor = null,
        public ?int $patch = null,
    ) {
    }
}
