<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class MetricsResult
{
    /**
     * @param array<string, string> $metric
     * @param list<list<mixed>> $values
     */
    public function __construct(
        public array $metric,
        public array $values,
    ) {
    }
}
