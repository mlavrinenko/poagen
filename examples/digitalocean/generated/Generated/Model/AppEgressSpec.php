<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppEgressTypeSpec;

final readonly class AppEgressSpec
{
    public function __construct(
        public ?AppEgressTypeSpec $type = null,
    ) {
    }
}
