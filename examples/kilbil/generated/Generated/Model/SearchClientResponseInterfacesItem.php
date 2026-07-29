<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\SearchClientResponseInterfacesItemInterfaceType;

final readonly class SearchClientResponseInterfacesItem
{
    public function __construct(
        public ?string $interface_id,
        public string $interface_name,
        public ?string $interface_os,
        public SearchClientResponseInterfacesItemInterfaceType $interface_type,
    ) {
    }
}
