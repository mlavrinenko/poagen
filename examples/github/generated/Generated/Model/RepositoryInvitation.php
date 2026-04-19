<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class RepositoryInvitation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'invitee' => ['invitee', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'inviter' => ['inviter', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'node_id' => ['node_id', null],
        'permissions' => ['permissions', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'url' => ['url', null],
        'expired' => ['expired', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public NullableSimpleUser $invitee,
        public NullableSimpleUser $inviter,
        public string $node_id,
        public string $permissions,
        public MinimalRepository $repository,
        public string $url,
        public ?bool $expired = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'invitee' => $this->invitee,
            'inviter' => $this->inviter,
            'node_id' => $this->node_id,
            'permissions' => $this->permissions,
            'repository' => $this->repository,
            'url' => $this->url,
            'expired' => $this->expired,
        ];
    }
}
