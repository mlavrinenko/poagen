<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AuthenticationToken implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'expires_at' => ['expires_at', ['datetime', null]],
        'token' => ['token', null],
        'permissions' => ['permissions', null],
        'repositories' => ['repositories', ['list', \Acme\GitHub\Generated\Model\Repository::class]],
        'repository_selection' => ['repository_selection', null],
        'single_file' => ['single_file', null],
    ];

    /**
     * @param ?array<string, mixed> $permissions
     * @param ?list<\Acme\GitHub\Generated\Model\Repository> $repositories
     */
    public function __construct(
        public DateTimeImmutable $expires_at,
        public string $token,
        public ?array $permissions = null,
        public ?array $repositories = null,
        public ?string $repository_selection = null,
        public ?string $single_file = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'expires_at' => $this->expires_at->format(\DateTimeInterface::RFC3339),
            'token' => $this->token,
            'permissions' => $this->permissions,
            'repositories' => $this->repositories,
            'repository_selection' => $this->repository_selection,
            'single_file' => $this->single_file,
        ];
    }
}
