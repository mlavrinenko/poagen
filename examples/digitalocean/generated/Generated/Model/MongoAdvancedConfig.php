<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class MongoAdvancedConfig
{
    public function __construct(
        public ?string $default_read_concern = null,
        public ?string $default_write_concern = null,
        public ?int $slow_op_threshold_ms = null,
        public ?int $transaction_lifetime_limit_seconds = null,
        public ?int $verbosity = null,
    ) {
    }
}
