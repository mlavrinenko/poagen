<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class IntegrationInstallationRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'account' => [
            'account',
            [
                'union',
                [\Acme\GitHub\Generated\Model\SimpleUser::class, \Acme\GitHub\Generated\Model\Enterprise::class],
                null,
            ],
        ],
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'requester' => ['requester', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'node_id' => ['node_id', null],
    ];

    public function __construct(
        public SimpleUser|Enterprise $account,
        public DateTimeImmutable $created_at,
        public int $id,
        public SimpleUser $requester,
        public ?string $node_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'account' => $this->account,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'requester' => $this->requester,
            'node_id' => $this->node_id,
        ];
    }
}
