<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class PartnerAttachmentWritable
{
    /**
     * @param list<string> $vpc_ids
     */
    public function __construct(
        public int $connection_bandwidth_in_mbps,
        public string $naas_provider,
        public string $name,
        public string $region,
        public array $vpc_ids,
        public ?PartnerAttachmentWritableBgp $bgp = null,
        public ?string $parent_uuid = null,
        public ?string $redundancy_zone = null,
    ) {
    }
}
