<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksSponsorship implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'node_id' => ['node_id', null],
        'privacy_level' => ['privacy_level', null],
        'sponsor' => ['sponsor', \Acme\GitHub\Generated\Model\WebhooksSponsorshipSponsor::class],
        'sponsorable' => ['sponsorable', \Acme\GitHub\Generated\Model\WebhooksSponsorshipSponsorable::class],
        'tier' => ['tier', \Acme\GitHub\Generated\Model\WebhooksSponsorshipTier::class],
        'maintainer' => ['maintainer', \Acme\GitHub\Generated\Model\WebhooksSponsorshipMaintainer::class],
    ];

    public function __construct(
        public string $created_at,
        public string $node_id,
        public string $privacy_level,
        public WebhooksSponsorshipSponsor $sponsor,
        public WebhooksSponsorshipSponsorable $sponsorable,
        public WebhooksSponsorshipTier $tier,
        public ?WebhooksSponsorshipMaintainer $maintainer = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'node_id' => $this->node_id,
            'privacy_level' => $this->privacy_level,
            'sponsor' => $this->sponsor,
            'sponsorable' => $this->sponsorable,
            'tier' => $this->tier,
            'maintainer' => $this->maintainer,
        ];
    }
}
