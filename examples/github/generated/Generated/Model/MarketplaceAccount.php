<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MarketplaceAccount
{
    public function __construct(
        public int $id,
        public string $login,
        public string $type,
        public string $url,
        public ?string $email = null,
        public ?string $node_id = null,
        public ?string $organization_billing_email = null,
    ) {
    }
}
