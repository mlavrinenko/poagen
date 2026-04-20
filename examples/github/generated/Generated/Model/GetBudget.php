<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GetBudget
{
    /**
     * @param mixed $budget_type
     */
    public function __construct(
        public GetBudgetBudget_alerting $budget_alerting,
        public int $budget_amount,
        public string $budget_entity_name,
        public string $budget_product_sku,
        public string $budget_scope,
        public $budget_type,
        public string $id,
        public bool $prevent_further_usage,
    ) {
    }
}
