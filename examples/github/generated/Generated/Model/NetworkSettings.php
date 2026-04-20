<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class NetworkSettings
{
    public function __construct(
        public string $id,
        public string $name,
        public string $region,
        public string $subnet_id,
        public ?string $network_configuration_id = null,
    ) {
    }
}
