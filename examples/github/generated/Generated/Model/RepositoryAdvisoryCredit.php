<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\SecurityAdvisoryCreditTypes;
use JsonSerializable;

final readonly class RepositoryAdvisoryCredit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'state' => ['state', null],
        'type' => ['type', ['enum', \Acme\GitHub\Generated\Enum\SecurityAdvisoryCreditTypes::class]],
        'user' => ['user', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    public function __construct(
        public string $state,
        public SecurityAdvisoryCreditTypes $type,
        public SimpleUser $user,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'state' => $this->state,
            'type' => $this->type,
            'user' => $this->user,
        ];
    }
}
