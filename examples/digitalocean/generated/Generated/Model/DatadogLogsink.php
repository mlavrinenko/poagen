<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatadogLogsink
{
    public function __construct(
        public string $datadog_api_key,
        public string $site,
    ) {
    }
}
