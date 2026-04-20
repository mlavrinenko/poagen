<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppLogDestinationOpenSearchSpec
{
    public function __construct(
        public ?AppLogDestinationOpenSearchSpecBasicAuth $basic_auth = null,
        public ?string $cluster_name = null,
        public ?string $endpoint = null,
        public ?string $index_name = null,
    ) {
    }
}
