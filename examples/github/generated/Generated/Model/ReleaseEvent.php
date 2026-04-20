<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReleaseEvent
{
    /**
     * @param mixed $release
     */
    public function __construct(
        public string $action,
        public $release,
    ) {
    }
}
