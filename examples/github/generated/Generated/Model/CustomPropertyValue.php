<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CustomPropertyValue
{
    /**
     * @param ?mixed $value
     */
    public function __construct(
        public string $property_name,
        public $value = null,
    ) {
    }
}
