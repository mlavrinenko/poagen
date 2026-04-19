<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class EnvironmentApprovals implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'comment' => ['comment', null],
        'environments' => ['environments', ['list', null]],
        'state' => ['state', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    /**
     * @param list<array<string, mixed>> $environments
     */
    public function __construct(
        public string $comment,
        public array $environments,
        public string $state,
        public SimpleUser $user,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'comment' => $this->comment,
            'environments' => $this->environments,
            'state' => $this->state,
            'user' => $this->user,
        ];
    }
}
