<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class LbFirewall
{
    /**
     * @param ?list<string> $allow
     * @param ?list<string> $deny
     */
    public function __construct(
        public ?array $allow = null,
        public ?array $deny = null,
    ) {
    }
}
