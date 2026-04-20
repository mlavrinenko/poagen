<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DoSettings
{
    /**
     * @param ?list<string> $service_cnames
     */
    public function __construct(
        public ?array $service_cnames = null,
    ) {
    }
}
