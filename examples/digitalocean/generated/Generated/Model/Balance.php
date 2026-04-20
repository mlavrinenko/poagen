<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Balance
{
    public function __construct(
        public ?string $account_balance = null,
        public ?DateTimeImmutable $generated_at = null,
        public ?string $month_to_date_balance = null,
        public ?string $month_to_date_usage = null,
    ) {
    }
}
