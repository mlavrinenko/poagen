<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class PartnerAttachment
{
    /**
     * @param ?list<string> $children
     * @param ?list<string> $vpc_ids
     */
    public function __construct(
        public ?PartnerAttachmentBgp $bgp = null,
        public ?array $children = null,
        public ?int $connection_bandwidth_in_mbps = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?string $naas_provider = null,
        public ?string $name = null,
        public ?string $parent_uuid = null,
        public ?string $region = null,
        public ?string $state = null,
        public ?array $vpc_ids = null,
    ) {
    }
}
