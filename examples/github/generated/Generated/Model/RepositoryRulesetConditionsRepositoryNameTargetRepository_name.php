<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRulesetConditionsRepositoryNameTargetRepository_name implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'exclude' => ['exclude', ['list', null]],
        'include' => ['include', ['list', null]],
        'protected' => ['protected', null],
    ];

    /**
     * @param ?list<string> $exclude
     * @param ?list<string> $include
     */
    public function __construct(
        public ?array $exclude = null,
        public ?array $include = null,
        public ?bool $protected = null,
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
            'protected' => $this->protected,
        ];
    }
}
