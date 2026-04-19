<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model;

use JsonSerializable;

final readonly class User implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract. See ADR-007.
     *
     * phpName => [wireKey, shape]
     * shape is one of: null (scalar pass-through), `\FQCN::class` (model ref), ['list', null] (list<scalar>), ['list', \FQCN::class] (list<Model>), ['scalar', \FQCN::class] (ScalarBinding VO), ['datetime', null] (format: date-time → \DateTimeImmutable), ['date', null] (format: date → \DateTimeImmutable), ['enum', \FQCN::class] (named enum component → backed enum).
     *
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}>
     */
    public const array PROPERTY_MAP = [
        'email' => ['email', null],
        'firstName' => ['firstName', null],
        'id' => ['id', null],
        'lastName' => ['lastName', null],
        'password' => ['password', null],
        'phone' => ['phone', null],
        'userStatus' => ['userStatus', null],
        'username' => ['username', null],
    ];

    public function __construct(
        public ?string $email = null,
        public ?string $firstName = null,
        public ?int $id = null,
        public ?string $lastName = null,
        public ?string $password = null,
        public ?string $phone = null,
        public ?int $userStatus = null,
        public ?string $username = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'firstName' => $this->firstName,
            'id' => $this->id,
            'lastName' => $this->lastName,
            'password' => $this->password,
            'phone' => $this->phone,
            'userStatus' => $this->userStatus,
            'username' => $this->username,
        ];
    }
}
