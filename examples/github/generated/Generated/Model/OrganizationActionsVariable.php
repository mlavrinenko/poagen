<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class OrganizationActionsVariable implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'name' => ['name', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'value' => ['value', null],
        'visibility' => ['visibility', null],
        'selected_repositories_url' => ['selected_repositories_url', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public string $name,
        public DateTimeImmutable $updated_at,
        public string $value,
        public string $visibility,
        public ?string $selected_repositories_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'name' => $this->name,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'value' => $this->value,
            'visibility' => $this->visibility,
            'selected_repositories_url' => $this->selected_repositories_url,
        ];
    }
}
