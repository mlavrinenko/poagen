<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppDatabaseSpec
{
    public function __construct(
        public string $name,
        public ?string $cluster_name = null,
        public ?string $db_name = null,
        public ?string $db_user = null,
        public ?string $engine = null,
        public ?bool $production = null,
        public ?string $version = null,
    ) {
    }
}
