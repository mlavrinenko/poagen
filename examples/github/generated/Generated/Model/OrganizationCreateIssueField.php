<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class OrganizationCreateIssueField implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'data_type' => ['data_type', null],
        'name' => ['name', null],
        'description' => ['description', null],
        'options' => ['options', ['list', null]],
        'visibility' => ['visibility', null],
    ];

    /**
     * @param ?list<array<string, mixed>> $options
     */
    public function __construct(
        public string $data_type,
        public string $name,
        public ?string $description = null,
        public ?array $options = null,
        public ?string $visibility = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'data_type' => $this->data_type,
            'name' => $this->name,
            'description' => $this->description,
            'options' => $this->options,
            'visibility' => $this->visibility,
        ];
    }
}
