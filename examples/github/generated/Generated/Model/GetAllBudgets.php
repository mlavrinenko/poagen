<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GetAllBudgets implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'budgets' => ['budgets', ['list', \Acme\GitHub\Generated\Model\Budget::class]],
        'has_next_page' => ['has_next_page', null],
        'total_count' => ['total_count', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\Budget> $budgets
     */
    public function __construct(
        public array $budgets,
        public ?bool $has_next_page = null,
        public ?int $total_count = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'budgets' => $this->budgets,
            'has_next_page' => $this->has_next_page,
            'total_count' => $this->total_count,
        ];
    }
}
