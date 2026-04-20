<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletActionRebuild
{
    /**
     * @param ?mixed $image
     */
    public function __construct(
        public string $type,
        public $image = null,
    ) {
    }
}
