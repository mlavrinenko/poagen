<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Budget implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'budget_alerting' => ['budget_alerting', \Acme\GitHub\Generated\Model\BudgetBudget_alerting::class],
        'budget_amount' => ['budget_amount', null],
        'budget_product_sku' => ['budget_product_sku', null],
        'budget_scope' => ['budget_scope', null],
        'budget_type' => ['budget_type', null],
        'id' => ['id', null],
        'prevent_further_usage' => ['prevent_further_usage', null],
        'budget_entity_name' => ['budget_entity_name', null],
    ];

    /**
     * @param mixed $budget_type
     */
    public function __construct(
        public BudgetBudget_alerting $budget_alerting,
        public int $budget_amount,
        public string $budget_product_sku,
        public string $budget_scope,
        public $budget_type,
        public string $id,
        public bool $prevent_further_usage,
        public ?string $budget_entity_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'budget_alerting' => $this->budget_alerting,
            'budget_amount' => $this->budget_amount,
            'budget_product_sku' => $this->budget_product_sku,
            'budget_scope' => $this->budget_scope,
            'budget_type' => $this->budget_type,
            'id' => $this->id,
            'prevent_further_usage' => $this->prevent_further_usage,
            'budget_entity_name' => $this->budget_entity_name,
        ];
    }
}
