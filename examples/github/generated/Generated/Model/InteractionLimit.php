<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\InteractionExpiry;
use Acme\GitHub\Generated\Enum\InteractionGroup;
use JsonSerializable;

final readonly class InteractionLimit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'limit' => ['limit', ['enum', \Acme\GitHub\Generated\Enum\InteractionGroup::class]],
        'expiry' => ['expiry', ['enum', \Acme\GitHub\Generated\Enum\InteractionExpiry::class]],
    ];

    public function __construct(
        public InteractionGroup $limit,
        public ?InteractionExpiry $expiry = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'limit' => $this->limit,
            'expiry' => $this->expiry,
        ];
    }
}
