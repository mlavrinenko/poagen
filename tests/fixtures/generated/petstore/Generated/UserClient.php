<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\User;

final readonly class UserClient implements UserClientInterface
{
    public function __construct(
        private TransportInterface $transport,
    ) {
    }

    public function createUser(User $body): User
    {
        return $this->transport->send(
            Endpoint::post('/user')->json($body),
            ResponseType::object(User::class),
        );
    }

    /**
     * @param list<User> $body
     */
    public function createUsersWithListInput(array $body): User
    {
        return $this->transport->send(
            Endpoint::post('/user/createWithList')->jsonList($body),
            ResponseType::object(User::class),
        );
    }

    public function loginUser(?string $username = null, ?string $password = null): string
    {
        return $this->transport->send(
            Endpoint::get('/user/login')
                ->query('username', $username)
                ->query('password', $password),
            ResponseType::string(),
        );
    }

    public function logoutUser(): void
    {
        $this->transport->send(
            Endpoint::get('/user/logout'),
            ResponseType::nothing(),
        );
    }

    public function getUserByName(string $username): User
    {
        return $this->transport->send(
            Endpoint::get('/user/{username}')->path('username', $username),
            ResponseType::object(User::class),
        );
    }

    public function updateUser(string $username, User $body): void
    {
        $this->transport->send(
            Endpoint::put('/user/{username}')->path('username', $username)->json($body),
            ResponseType::nothing(),
        );
    }

    public function deleteUser(string $username): void
    {
        $this->transport->send(
            Endpoint::delete('/user/{username}')->path('username', $username),
            ResponseType::nothing(),
        );
    }
}
