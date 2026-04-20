<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiAwsdataSource
{
    public function __construct(
        public ?string $bucket_name = null,
        public ?string $item_path = null,
        public ?string $key_id = null,
        public ?string $region = null,
        public ?string $secret_key = null,
    ) {
    }
}
