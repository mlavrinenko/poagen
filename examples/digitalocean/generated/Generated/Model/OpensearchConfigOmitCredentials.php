<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OpensearchConfigOmitCredentials
{
    public function __construct(
        public ?string $cluster_name = null,
        public ?string $cluster_uuid = null,
        public ?string $endpoint = null,
        public ?string $id = null,
        public ?string $index_name = null,
        public ?int $retention_days = null,
    ) {
    }
}
