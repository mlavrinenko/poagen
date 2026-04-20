<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class MemberCurrentUtilization
{
    public function __construct(
        public ?float $cpu = null,
        public ?float $memory = null,
    ) {
    }
}
