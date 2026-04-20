<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsActionAttach
{
    public function __construct(
        public string $type,
        public ?NfsActionAttachParams $params = null,
        public ?string $region = null,
    ) {
    }
}
