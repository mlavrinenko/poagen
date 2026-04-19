<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DatabasesBasicAuthCredentials implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'basic_auth_password' => ['basic_auth_password', null],
        'basic_auth_username' => ['basic_auth_username', null],
    ];

    public function __construct(
        public ?string $basic_auth_password = null,
        public ?string $basic_auth_username = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'basic_auth_password' => $this->basic_auth_password,
            'basic_auth_username' => $this->basic_auth_username,
        ];
    }
}
