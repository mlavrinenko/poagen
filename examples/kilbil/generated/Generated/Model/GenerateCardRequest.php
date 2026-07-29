<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\GenerateCardRequestOuterSystemsInterfaceType;

final readonly class GenerateCardRequest
{
    public function __construct(
        public int $client_id,
        public GenerateCardRequestOuterSystemsInterfaceType $outer_systems_interface_type,
    ) {
    }
}
