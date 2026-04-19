<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class FirewallRuleTarget implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'addresses' => ['addresses', ['list', null]],
        'droplet_ids' => ['droplet_ids', ['list', null]],
        'kubernetes_ids' => ['kubernetes_ids', ['list', null]],
        'load_balancer_uids' => ['load_balancer_uids', ['list', null]],
        'tags' => ['tags', null],
    ];

    /**
     * @param ?list<string> $addresses
     * @param ?list<int> $droplet_ids
     * @param ?list<string> $kubernetes_ids
     * @param ?list<string> $load_balancer_uids
     * @param ?mixed $tags
     */
    public function __construct(
        public ?array $addresses = null,
        public ?array $droplet_ids = null,
        public ?array $kubernetes_ids = null,
        public ?array $load_balancer_uids = null,
        public $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'addresses' => $this->addresses,
            'droplet_ids' => $this->droplet_ids,
            'kubernetes_ids' => $this->kubernetes_ids,
            'load_balancer_uids' => $this->load_balancer_uids,
            'tags' => $this->tags,
        ];
    }
}
