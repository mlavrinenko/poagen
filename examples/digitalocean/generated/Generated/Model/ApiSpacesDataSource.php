<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiSpacesDataSource
{
    public function __construct(
        public ?string $bucket_name = null,
        public ?string $item_path = null,
        public ?string $region = null,
    ) {
    }
}
