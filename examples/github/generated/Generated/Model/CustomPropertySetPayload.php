<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CustomPropertySetPayload
{
    /**
     * @param ?list<string> $allowed_values
     * @param ?mixed $default_value
     */
    public function __construct(
        public string $value_type,
        public ?array $allowed_values = null,
        public $default_value = null,
        public ?string $description = null,
        public ?bool $require_explicit_values = null,
        public ?bool $required = null,
        public ?string $values_editable_by = null,
    ) {
    }
}
