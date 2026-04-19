<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class OidcCustomPropertyInclusion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'custom_property_name' => ['custom_property_name', null],
        'inclusion_source' => ['inclusion_source', null],
    ];

    public function __construct(
        public string $custom_property_name,
        public string $inclusion_source,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'custom_property_name' => $this->custom_property_name,
            'inclusion_source' => $this->inclusion_source,
        ];
    }
}
