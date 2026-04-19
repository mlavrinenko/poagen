<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CustomProperty implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'property_name' => ['property_name', null],
        'value_type' => ['value_type', null],
        'allowed_values' => ['allowed_values', ['list', null]],
        'default_value' => ['default_value', null],
        'description' => ['description', null],
        'require_explicit_values' => ['require_explicit_values', null],
        'required' => ['required', null],
        'source_type' => ['source_type', null],
        'url' => ['url', null],
        'values_editable_by' => ['values_editable_by', null],
    ];

    /**
     * @param ?list<string> $allowed_values
     * @param ?mixed $default_value
     */
    public function __construct(
        public string $property_name,
        public string $value_type,
        public ?array $allowed_values = null,
        public $default_value = null,
        public ?string $description = null,
        public ?bool $require_explicit_values = null,
        public ?bool $required = null,
        public ?string $source_type = null,
        public ?string $url = null,
        public ?string $values_editable_by = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'property_name' => $this->property_name,
            'value_type' => $this->value_type,
            'allowed_values' => $this->allowed_values,
            'default_value' => $this->default_value,
            'description' => $this->description,
            'require_explicit_values' => $this->require_explicit_values,
            'required' => $this->required,
            'source_type' => $this->source_type,
            'url' => $this->url,
            'values_editable_by' => $this->values_editable_by,
        ];
    }
}
