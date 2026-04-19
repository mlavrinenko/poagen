<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleCommitMessagePatternParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'operator' => ['operator', null],
        'pattern' => ['pattern', null],
        'name' => ['name', null],
        'negate' => ['negate', null],
    ];

    public function __construct(
        public string $operator,
        public string $pattern,
        public ?string $name = null,
        public ?bool $negate = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'operator' => $this->operator,
            'pattern' => $this->pattern,
            'name' => $this->name,
            'negate' => $this->negate,
        ];
    }
}
