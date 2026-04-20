<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiMeta
{
    public function __construct(
        public ?int $page = null,
        public ?int $pages = null,
        public ?int $total = null,
    ) {
    }
}
