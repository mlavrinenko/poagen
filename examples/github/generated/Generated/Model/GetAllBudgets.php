<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GetAllBudgets
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\Budget> $budgets
     */
    public function __construct(
        public array $budgets,
        public ?bool $has_next_page = null,
        public ?int $total_count = null,
    ) {
    }
}
