<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksPreviousMarketplacePurchaseAccount implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'login' => ['login', null],
        'node_id' => ['node_id', null],
        'organization_billing_email' => ['organization_billing_email', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public int $id,
        public string $login,
        public string $node_id,
        public ?string $organization_billing_email = null,
        public string $type,
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
            'node_id' => $this->node_id,
            'organization_billing_email' => $this->organization_billing_email,
            'type' => $this->type,
        ];
    }
}
