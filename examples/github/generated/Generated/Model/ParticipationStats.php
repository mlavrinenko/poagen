<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ParticipationStats implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['all' => ['all', ['list', null]], 'owner' => ['owner', ['list', null]]];

    /**
     * @param list<int> $all
     * @param list<int> $owner
     */
    public function __construct(
        public array $all,
        public array $owner,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'all' => $this->all,
            'owner' => $this->owner,
        ];
    }
}
