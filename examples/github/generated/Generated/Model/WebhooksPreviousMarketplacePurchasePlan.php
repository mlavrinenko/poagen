<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksPreviousMarketplacePurchasePlan
{
    /**
     * @param list<string> $bullets
     */
    public function __construct(
        public array $bullets,
        public string $description,
        public bool $has_free_trial,
        public int $id,
        public int $monthly_price_in_cents,
        public string $name,
        public string $price_model,
        public ?string $unit_name = null,
        public int $yearly_price_in_cents,
    ) {
    }
}
