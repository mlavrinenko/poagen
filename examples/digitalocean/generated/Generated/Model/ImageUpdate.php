<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\Distribution;

final readonly class ImageUpdate
{
    public function __construct(
        public ?ImageDescription $description = null,
        public ?Distribution $distribution = null,
        public ?ImageName $name = null,
    ) {
    }
}
