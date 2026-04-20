<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class LogsinkBase
{
    public function __construct(
        public ?string $sink_name = null,
        public ?string $sink_type = null,
    ) {
    }
}
