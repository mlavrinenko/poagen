<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SubscriptionTierExtended
{
    /**
     * @param ?list<string> $eligibility_reasons
     */
    public function __construct(
        public ?array $eligibility_reasons = null,
        public ?bool $eligible = null,
    ) {
    }
}
