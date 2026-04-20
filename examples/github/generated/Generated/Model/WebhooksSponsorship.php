<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksSponsorship
{
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
}
