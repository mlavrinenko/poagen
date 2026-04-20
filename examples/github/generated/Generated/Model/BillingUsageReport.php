<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BillingUsageReport
{
    /**
     * @param ?list<array<string, mixed>> $usageItems
     */
    public function __construct(
        public ?array $usageItems = null,
    ) {
    }
}
