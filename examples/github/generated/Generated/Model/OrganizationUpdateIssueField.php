<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class OrganizationUpdateIssueField implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'name' => ['name', null],
        'options' => ['options', ['list', null]],
        'visibility' => ['visibility', null],
    ];

    /**
     * @param ?list<array<string, mixed>> $options
     */
    public function __construct(
        public ?string $description = null,
        public ?string $name = null,
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
            'description' => $this->description,
            'name' => $this->name,
            'options' => $this->options,
            'visibility' => $this->visibility,
        ];
    }
}
