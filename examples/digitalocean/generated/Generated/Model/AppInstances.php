<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppInstances
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppInstance> $instances
     */
    public function __construct(
        public ?array $instances = null,
    ) {
    }
}
