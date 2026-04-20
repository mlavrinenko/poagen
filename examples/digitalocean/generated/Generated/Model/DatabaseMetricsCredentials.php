<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseMetricsCredentials
{
    public function __construct(
        public ?DatabasesBasicAuthCredentials $credentials = null,
    ) {
    }
}
