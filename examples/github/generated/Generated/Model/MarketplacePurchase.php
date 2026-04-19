<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class MarketplacePurchase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'login' => ['login', null],
        'marketplace_purchase' => [
            'marketplace_purchase',
            \Acme\GitHub\Generated\Model\MarketplacePurchaseMarketplace_purchase::class,
        ],
        'type' => ['type', null],
        'url' => ['url', null],
        'email' => ['email', null],
        'marketplace_pending_change' => [
            'marketplace_pending_change',
            \Acme\GitHub\Generated\Model\MarketplacePurchaseMarketplace_pending_change::class,
        ],
        'organization_billing_email' => ['organization_billing_email', null],
    ];

    public function __construct(
        public int $id,
        public string $login,
        public MarketplacePurchaseMarketplace_purchase $marketplace_purchase,
        public string $type,
        public string $url,
        public ?string $email = null,
        public ?MarketplacePurchaseMarketplace_pending_change $marketplace_pending_change = null,
        public ?string $organization_billing_email = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'marketplace_purchase' => $this->marketplace_purchase,
            'type' => $this->type,
            'url' => $this->url,
            'email' => $this->email,
            'marketplace_pending_change' => $this->marketplace_pending_change,
            'organization_billing_email' => $this->organization_billing_email,
        ];
    }
}
