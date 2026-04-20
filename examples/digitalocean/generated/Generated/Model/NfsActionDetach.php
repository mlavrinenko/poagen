<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsActionDetach
{
    public function __construct(
        public string $type,
        public ?NfsActionDetachParams $params = null,
        public ?string $region = null,
    ) {
    }
}
