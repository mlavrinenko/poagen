<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Model;

final readonly class PetShipping
{
    public function __construct(
        public string $address,
        public ?string $zip = null,
    ) {
    }
}
