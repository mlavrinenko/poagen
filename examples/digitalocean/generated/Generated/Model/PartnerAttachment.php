<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PartnerAttachment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'bgp' => ['bgp', \Acme\DigitalOcean\Generated\Model\PartnerAttachmentBgp::class],
        'children' => ['children', ['list', null]],
        'connection_bandwidth_in_mbps' => ['connection_bandwidth_in_mbps', null],
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'naas_provider' => ['naas_provider', null],
        'name' => ['name', null],
        'parent_uuid' => ['parent_uuid', null],
        'region' => ['region', null],
        'state' => ['state', null],
        'vpc_ids' => ['vpc_ids', ['list', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'bgp' => $this->bgp,
            'children' => $this->children,
            'connection_bandwidth_in_mbps' => $this->connection_bandwidth_in_mbps,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'naas_provider' => $this->naas_provider,
            'name' => $this->name,
            'parent_uuid' => $this->parent_uuid,
            'region' => $this->region,
            'state' => $this->state,
            'vpc_ids' => $this->vpc_ids,
        ];
    }
}
