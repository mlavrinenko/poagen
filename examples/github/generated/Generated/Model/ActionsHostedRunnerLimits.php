<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsHostedRunnerLimits implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'public_ips' => ['public_ips', \Acme\GitHub\Generated\Model\ActionsHostedRunnerLimitsPublic_ips::class],
    ];

    public function __construct(
        public ActionsHostedRunnerLimitsPublic_ips $public_ips,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'public_ips' => $this->public_ips,
        ];
    }
}
