<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class NullablePinnedIssueComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'pinned_at' => ['pinned_at', ['datetime', null]],
        'pinned_by' => ['pinned_by', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
    ];

    public function __construct(
        public DateTimeImmutable $pinned_at,
        public NullableSimpleUser $pinned_by,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'pinned_at' => $this->pinned_at->format(\DateTimeInterface::RFC3339),
            'pinned_by' => $this->pinned_by,
        ];
    }
}
