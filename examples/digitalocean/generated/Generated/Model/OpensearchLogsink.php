<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OpensearchLogsink
{
    public function __construct(
        public string $index_prefix,
        public string $url,
        public ?string $ca = null,
        public ?int $index_days_max = null,
        public ?float $timeout = null,
    ) {
    }
}
