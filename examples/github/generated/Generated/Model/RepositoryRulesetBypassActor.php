<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRulesetBypassActor implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actor_type' => ['actor_type', null],
        'actor_id' => ['actor_id', null],
        'bypass_mode' => ['bypass_mode', null],
    ];

    public function __construct(
        public string $actor_type,
        public ?int $actor_id = null,
        public ?string $bypass_mode = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actor_type' => $this->actor_type,
            'actor_id' => $this->actor_id,
            'bypass_mode' => $this->bypass_mode,
        ];
    }
}
