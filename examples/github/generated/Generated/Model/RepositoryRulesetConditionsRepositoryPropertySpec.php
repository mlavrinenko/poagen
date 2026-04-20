<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRulesetConditionsRepositoryPropertySpec
{
    /**
     * @param list<string> $property_values
     */
    public function __construct(
        public string $name,
        public array $property_values,
        public ?string $source = null,
    ) {
    }
}
