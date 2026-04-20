<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsActionSnapshot
{
    public function __construct(
        public string $type,
        public ?NfsActionSnapshotParams $params = null,
        public ?string $region = null,
    ) {
    }
}
