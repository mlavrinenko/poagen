<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookPushPusher implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'date' => ['date', ['datetime', null]],
        'email' => ['email', null],
        'username' => ['username', null],
    ];

    public function __construct(
        public string $name,
        public ?DateTimeImmutable $date = null,
        public ?string $email = null,
        public ?string $username = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'date' => $this->date?->format(\DateTimeInterface::RFC3339),
            'email' => $this->email,
            'username' => $this->username,
        ];
    }
}
