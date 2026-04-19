<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class NetworkSettings implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'name' => ['name', null],
        'region' => ['region', null],
        'subnet_id' => ['subnet_id', null],
        'network_configuration_id' => ['network_configuration_id', null],
    ];

    public function __construct(
        public string $id,
        public string $name,
        public string $region,
        public string $subnet_id,
        public ?string $network_configuration_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'region' => $this->region,
            'subnet_id' => $this->subnet_id,
            'network_configuration_id' => $this->network_configuration_id,
        ];
    }
}
