<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OidcCustomPropertyInclusion
{
    public function __construct(
        public string $custom_property_name,
        public string $inclusion_source,
    ) {
    }
}
