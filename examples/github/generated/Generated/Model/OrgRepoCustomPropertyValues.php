<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class OrgRepoCustomPropertyValues implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'properties' => ['properties', ['list', \Acme\GitHub\Generated\Model\CustomPropertyValue::class]],
        'repository_full_name' => ['repository_full_name', null],
        'repository_id' => ['repository_id', null],
        'repository_name' => ['repository_name', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\CustomPropertyValue> $properties
     */
    public function __construct(
        public array $properties,
        public string $repository_full_name,
        public int $repository_id,
        public string $repository_name,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'properties' => $this->properties,
            'repository_full_name' => $this->repository_full_name,
            'repository_id' => $this->repository_id,
            'repository_name' => $this->repository_name,
        ];
    }
}
