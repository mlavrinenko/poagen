<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppLogDestinationDatadogSpec
{
    public function __construct(
        public string $api_key,
        public ?string $endpoint = null,
    ) {
    }
}
