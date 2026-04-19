<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsHostedRunnerLimitsPublic_ips implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['current_usage' => ['current_usage', null], 'maximum' => ['maximum', null]];

    public function __construct(
        public int $current_usage,
        public int $maximum,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'current_usage' => $this->current_usage,
            'maximum' => $this->maximum,
        ];
    }
}
