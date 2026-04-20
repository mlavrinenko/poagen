<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsRequest
{
    /**
     * @param list<string> $vpc_ids
     */
    public function __construct(
        public string $name,
        public string $region,
        public int $size_gib,
        public array $vpc_ids,
        public ?string $performance_tier = null,
    ) {
    }
}
