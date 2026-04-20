<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class MetricsData
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\MetricsResult> $result
     */
    public function __construct(
        public array $result,
        public string $resultType,
    ) {
    }
}
