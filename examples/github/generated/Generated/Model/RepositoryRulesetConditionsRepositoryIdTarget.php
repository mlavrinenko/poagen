<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRulesetConditionsRepositoryIdTarget implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'repository_id' => [
            'repository_id',
            \Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryIdTargetRepository_id::class,
        ],
    ];

    public function __construct(
        public RepositoryRulesetConditionsRepositoryIdTargetRepository_id $repository_id,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'repository_id' => $this->repository_id,
        ];
    }
}
