<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodespaceWithFullRepositoryGit_status implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'ahead' => ['ahead', null],
        'behind' => ['behind', null],
        'has_uncommitted_changes' => ['has_uncommitted_changes', null],
        'has_unpushed_changes' => ['has_unpushed_changes', null],
        'ref' => ['ref', null],
    ];

    public function __construct(
        public ?int $ahead = null,
        public ?int $behind = null,
        public ?bool $has_uncommitted_changes = null,
        public ?bool $has_unpushed_changes = null,
        public ?string $ref = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ahead' => $this->ahead,
            'behind' => $this->behind,
            'has_uncommitted_changes' => $this->has_uncommitted_changes,
            'has_unpushed_changes' => $this->has_unpushed_changes,
            'ref' => $this->ref,
        ];
    }
}
