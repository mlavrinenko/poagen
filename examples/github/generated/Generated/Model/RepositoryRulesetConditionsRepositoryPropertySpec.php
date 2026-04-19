<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRulesetConditionsRepositoryPropertySpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'property_values' => ['property_values', ['list', null]],
        'source' => ['source', null],
    ];

    /**
     * @param list<string> $property_values
     */
    public function __construct(
        public string $name,
        public array $property_values,
        public ?string $source = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'property_values' => $this->property_values,
            'source' => $this->source,
        ];
    }
}
