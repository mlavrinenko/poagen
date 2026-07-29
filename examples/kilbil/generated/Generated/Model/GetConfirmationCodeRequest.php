<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\GetConfirmationCodeRequestOuterSystemsInterfaceType;

final readonly class GetConfirmationCodeRequest
{
    public function __construct(
        public int $client_id,
        public GetConfirmationCodeRequestOuterSystemsInterfaceType $outer_systems_interface_type,
    ) {
    }
}
