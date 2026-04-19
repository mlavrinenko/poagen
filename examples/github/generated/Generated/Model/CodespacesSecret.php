<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CodespacesSecret implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'name' => ['name', null],
        'selected_repositories_url' => ['selected_repositories_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'visibility' => ['visibility', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public string $name,
        public string $selected_repositories_url,
        public DateTimeImmutable $updated_at,
        public string $visibility,
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
            'selected_repositories_url' => $this->selected_repositories_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'visibility' => $this->visibility,
        ];
    }
}
