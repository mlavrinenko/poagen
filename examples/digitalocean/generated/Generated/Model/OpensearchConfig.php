<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OpensearchConfig
{
    public function __construct(
        public string $endpoint,
        public ?string $cluster_name = null,
        public ?string $cluster_uuid = null,
        public ?OpensearchConfigCredentials $credentials = null,
        public ?string $id = null,
        public ?string $index_name = null,
        public ?int $retention_days = null,
    ) {
    }
}
