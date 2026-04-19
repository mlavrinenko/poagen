<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CommitSearchResultItemCommitAuthor implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'date' => ['date', ['datetime', null]],
        'email' => ['email', null],
        'name' => ['name', null],
    ];

    public function __construct(
        public DateTimeImmutable $date,
        public string $email,
        public string $name,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'date' => $this->date->format(\DateTimeInterface::RFC3339),
            'email' => $this->email,
            'name' => $this->name,
        ];
    }
}
