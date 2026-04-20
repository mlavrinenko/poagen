<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ClusterAutoscalerConfiguration
{
    /**
     * @param ?list<string> $expanders
     */
    public function __construct(
        public ?array $expanders = null,
        public ?string $scale_down_unneeded_time = null,
        public ?float $scale_down_utilization_threshold = null,
    ) {
    }
}
