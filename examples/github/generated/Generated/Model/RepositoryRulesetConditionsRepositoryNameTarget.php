<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRulesetConditionsRepositoryNameTarget implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'repository_name' => [
            'repository_name',
            \Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryNameTargetRepository_name::class,
        ],
    ];

    public function __construct(
        public RepositoryRulesetConditionsRepositoryNameTargetRepository_name $repository_name,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'repository_name' => $this->repository_name,
        ];
    }
}
