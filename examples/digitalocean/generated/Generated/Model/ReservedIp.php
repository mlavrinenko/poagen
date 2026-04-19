<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ReservedIp implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'droplet' => ['droplet', null],
        'ip' => ['ip', null],
        'locked' => ['locked', null],
        'project_id' => ['project_id', null],
        'region' => ['region', null],
    ];

    /**
     * @param ?mixed $droplet
     * @param ?mixed $region
     */
    public function __construct(
        public $droplet = null,
        public ?string $ip = null,
        public ?bool $locked = null,
        public ?string $project_id = null,
        public $region = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'droplet' => $this->droplet,
            'ip' => $this->ip,
            'locked' => $this->locked,
            'project_id' => $this->project_id,
            'region' => $this->region,
        ];
    }
}
