<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class BillingDataPoint
{
    public function __construct(
        public ?string $description = null,
        public ?string $group_description = null,
        public ?string $region = null,
        public ?string $sku = null,
        #[Format('date')]
        public ?DateTimeImmutable $start_date = null,
        public ?string $total_amount = null,
        public ?string $usage_team_urn = null,
    ) {
    }
}
