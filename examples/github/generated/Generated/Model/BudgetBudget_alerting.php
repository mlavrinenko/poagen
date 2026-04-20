<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BudgetBudget_alerting
{
    /**
     * @param list<string> $alert_recipients
     */
    public function __construct(
        public array $alert_recipients,
        public bool $will_alert,
    ) {
    }
}
