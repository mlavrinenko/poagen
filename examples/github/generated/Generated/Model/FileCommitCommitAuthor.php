<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class FileCommitCommitAuthor implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['date' => ['date', null], 'email' => ['email', null], 'name' => ['name', null]];

    public function __construct(
        public ?string $date = null,
        public ?string $email = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'date' => $this->date,
            'email' => $this->email,
            'name' => $this->name,
        ];
    }
}
