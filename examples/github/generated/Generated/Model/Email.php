<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Email implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'email' => ['email', null],
        'primary' => ['primary', null],
        'verified' => ['verified', null],
        'visibility' => ['visibility', null],
    ];

    public function __construct(
        public string $email,
        public bool $primary,
        public bool $verified,
        public ?string $visibility = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'primary' => $this->primary,
            'verified' => $this->verified,
            'visibility' => $this->visibility,
        ];
    }
}
