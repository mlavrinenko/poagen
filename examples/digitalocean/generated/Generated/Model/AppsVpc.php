<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsVpc implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'egress_ips' => ['egress_ips', ['list', \Acme\DigitalOcean\Generated\Model\AppsVpcEgressIp::class]],
        'id' => ['id', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsVpcEgressIp> $egress_ips
     */
    public function __construct(
        public ?array $egress_ips = null,
        public ?string $id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'egress_ips' => $this->egress_ips,
            'id' => $this->id,
        ];
    }
}
