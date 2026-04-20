<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class NullableMinimalRepositoryLicense
{
    public function __construct(
        public ?string $key = null,
        public ?string $name = null,
        public ?string $node_id = null,
        public ?string $spdx_id = null,
        public ?string $url = null,
    ) {
    }
}
