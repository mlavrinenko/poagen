<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model;

final readonly class User
{
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
}
