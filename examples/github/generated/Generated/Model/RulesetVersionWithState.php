<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class RulesetVersionWithState implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actor' => ['actor', \Acme\GitHub\Generated\Model\RulesetVersionWithStateActor::class],
        'state' => ['state', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'version_id' => ['version_id', null],
    ];

    /**
     * @param array<string, mixed> $state
     */
    public function __construct(
        public RulesetVersionWithStateActor $actor,
        public array $state,
        public DateTimeImmutable $updated_at,
        public int $version_id,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actor' => $this->actor,
            'state' => $this->state,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'version_id' => $this->version_id,
        ];
    }
}
