<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CustomPropertyValue implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['property_name' => ['property_name', null], 'value' => ['value', null]];

    /**
     * @param ?mixed $value
     */
    public function __construct(
        public string $property_name,
        public $value = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'property_name' => $this->property_name,
            'value' => $this->value,
        ];
    }
}
