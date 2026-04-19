<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRulesetConditionsRepositoryPropertyTargetRepository_property implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'exclude' => [
            'exclude',
            ['list', \Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryPropertySpec::class],
        ],
        'include' => [
            'include',
            ['list', \Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryPropertySpec::class],
        ],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryPropertySpec> $exclude
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryPropertySpec> $include
     */
    public function __construct(
        public ?array $exclude = null,
        public ?array $include = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'exclude' => $this->exclude,
            'include' => $this->include,
        ];
    }
}
