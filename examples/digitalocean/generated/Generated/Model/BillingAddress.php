<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class BillingAddress
{
    public function __construct(
        public ?string $address_line1 = null,
        public ?string $address_line2 = null,
        public ?string $city = null,
        public ?string $country_iso2_code = null,
        public ?string $created_at = null,
        public ?string $postal_code = null,
        public ?string $region = null,
        public ?string $updated_at = null,
    ) {
    }
}
