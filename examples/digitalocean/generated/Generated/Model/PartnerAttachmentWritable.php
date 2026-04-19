<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class PartnerAttachmentWritable implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'connection_bandwidth_in_mbps' => ['connection_bandwidth_in_mbps', null],
        'naas_provider' => ['naas_provider', null],
        'name' => ['name', null],
        'region' => ['region', null],
        'vpc_ids' => ['vpc_ids', ['list', null]],
        'bgp' => ['bgp', \Acme\DigitalOcean\Generated\Model\PartnerAttachmentWritableBgp::class],
        'parent_uuid' => ['parent_uuid', null],
        'redundancy_zone' => ['redundancy_zone', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'connection_bandwidth_in_mbps' => $this->connection_bandwidth_in_mbps,
            'naas_provider' => $this->naas_provider,
            'name' => $this->name,
            'region' => $this->region,
            'vpc_ids' => $this->vpc_ids,
            'bgp' => $this->bgp,
            'parent_uuid' => $this->parent_uuid,
            'redundancy_zone' => $this->redundancy_zone,
        ];
    }
}
