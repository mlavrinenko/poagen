<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Subscription
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?SubscriptionTierBase $tier = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
