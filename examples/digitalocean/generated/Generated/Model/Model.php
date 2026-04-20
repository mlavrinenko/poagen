<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Model
{
    public function __construct(
        public int $created,
        public string $id,
        public string $object,
        public string $owned_by,
    ) {
    }
}
