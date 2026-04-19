<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class GlbSettings implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cdn' => ['cdn', \Acme\DigitalOcean\Generated\Model\GlbSettingsCdn::class],
        'failover_threshold' => ['failover_threshold', null],
        'region_priorities' => ['region_priorities', null],
        'target_port' => ['target_port', null],
        'target_protocol' => ['target_protocol', null],
    ];

    /**
     * @param ?array<string, int> $region_priorities
     */
    public function __construct(
        public ?GlbSettingsCdn $cdn = null,
        public ?int $failover_threshold = null,
        public ?array $region_priorities = null,
        public ?int $target_port = null,
        public ?string $target_protocol = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cdn' => $this->cdn,
            'failover_threshold' => $this->failover_threshold,
            'region_priorities' => $this->region_priorities,
            'target_port' => $this->target_port,
            'target_protocol' => $this->target_protocol,
        ];
    }
}
