<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class BillingAddress implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'address_line1' => ['address_line1', null],
        'address_line2' => ['address_line2', null],
        'city' => ['city', null],
        'country_iso2_code' => ['country_iso2_code', null],
        'created_at' => ['created_at', null],
        'postal_code' => ['postal_code', null],
        'region' => ['region', null],
        'updated_at' => ['updated_at', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'country_iso2_code' => $this->country_iso2_code,
            'created_at' => $this->created_at,
            'postal_code' => $this->postal_code,
            'region' => $this->region,
            'updated_at' => $this->updated_at,
        ];
    }
}
