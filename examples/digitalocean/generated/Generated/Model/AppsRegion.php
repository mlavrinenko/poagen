<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsRegion
{
    /**
     * @param ?list<string> $data_centers
     */
    public function __construct(
        public ?string $continent = null,
        public ?array $data_centers = null,
        public ?bool $default = null,
        public ?bool $disabled = null,
        public ?string $flag = null,
        public ?string $label = null,
        public ?string $reason = null,
        public ?string $slug = null,
    ) {
    }
}
