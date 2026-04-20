<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsActionSwitchPerformanceTier
{
    public function __construct(
        public string $type,
        public ?NfsActionSwitchPerformanceTierParams $params = null,
        public ?string $region = null,
    ) {
    }
}
