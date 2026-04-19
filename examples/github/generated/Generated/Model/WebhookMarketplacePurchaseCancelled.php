<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookMarketplacePurchaseCancelled implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'effective_date' => ['effective_date', null],
        'marketplace_purchase' => ['marketplace_purchase', \Acme\GitHub\Generated\Model\WebhooksMarketplacePurchase::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'previous_marketplace_purchase' => [
            'previous_marketplace_purchase',
            \Acme\GitHub\Generated\Model\WebhooksPreviousMarketplacePurchase::class,
        ],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
    ];

    public function __construct(
        public string $action,
        public string $effective_date,
        public WebhooksMarketplacePurchase $marketplace_purchase,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?WebhooksPreviousMarketplacePurchase $previous_marketplace_purchase = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'effective_date' => $this->effective_date,
            'marketplace_purchase' => $this->marketplace_purchase,
            'sender' => $this->sender,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'previous_marketplace_purchase' => $this->previous_marketplace_purchase,
            'repository' => $this->repository,
        ];
    }
}
