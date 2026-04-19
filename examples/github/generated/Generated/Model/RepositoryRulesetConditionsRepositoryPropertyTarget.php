<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRulesetConditionsRepositoryPropertyTarget implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'repository_property' => [
            'repository_property',
            \Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryPropertyTargetRepository_property::class,
        ],
    ];

    public function __construct(
        public RepositoryRulesetConditionsRepositoryPropertyTargetRepository_property $repository_property,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'repository_property' => $this->repository_property,
        ];
    }
}
