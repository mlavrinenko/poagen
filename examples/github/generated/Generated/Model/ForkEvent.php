<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ForkEvent
{
    public function __construct(
        public string $action,
        public ForkEventForkee $forkee,
    ) {
    }
}
