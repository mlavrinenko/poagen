<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class GlbSettings
{
    /**
     * @param ?array<string, int> $region_priorities
     */
    public function __construct(
        public ?GlbSettingsCdn $cdn = null,
        public ?int $failover_threshold = null,
        public ?array $region_priorities = null,
        public ?int $target_port = null,
        public ?string $target_protocol = null,
    ) {
    }
}
