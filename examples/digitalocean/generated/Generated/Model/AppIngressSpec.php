<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppIngressSpec
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppIngressSpecRule> $rules
     */
    public function __construct(
        public ?array $rules = null,
    ) {
    }
}
