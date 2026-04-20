<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DestinationRequest
{
    public function __construct(
        public OpensearchConfigRequest $config,
        public string $type,
        public ?string $name = null,
    ) {
    }
}
