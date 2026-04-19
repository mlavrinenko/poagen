<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class FirewallRules implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'inbound_rules' => ['inbound_rules', ['list', null]],
        'outbound_rules' => ['outbound_rules', ['list', null]],
    ];

    /**
     * @param ?list<mixed> $inbound_rules
     * @param ?list<mixed> $outbound_rules
     */
    public function __construct(
        public ?array $inbound_rules = null,
        public ?array $outbound_rules = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'inbound_rules' => $this->inbound_rules,
            'outbound_rules' => $this->outbound_rules,
        ];
    }
}
