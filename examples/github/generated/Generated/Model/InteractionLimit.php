<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\InteractionExpiry;
use Acme\GitHub\Generated\Enum\InteractionGroup;

final readonly class InteractionLimit
{
    public function __construct(
        public InteractionGroup $limit,
        public ?InteractionExpiry $expiry = null,
    ) {
    }
}
