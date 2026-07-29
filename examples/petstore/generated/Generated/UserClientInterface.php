<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated;

use Acme\Petstore\Generated\Model\User;

/**
 * The contract for the `user` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface UserClientInterface
{
    public function createUser(User $body): User;

    /**
     * @param list<\Acme\Petstore\Generated\Model\User> $body
     */
    public function createUsersWithListInput(array $body): User;

    public function loginUser(?string $username = null, ?string $password = null): string;

    public function logoutUser(): void;

    public function getUserByName(string $username): User;

    public function updateUser(string $username, User $body): void;

    public function deleteUser(string $username): void;
}
