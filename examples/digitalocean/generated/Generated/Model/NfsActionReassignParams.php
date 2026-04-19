<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class NfsActionReassignParams implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['new_vpc_id' => ['new_vpc_id', null], 'old_vpc_id' => ['old_vpc_id', null]];

    public function __construct(
        public string $new_vpc_id,
        public string $old_vpc_id,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'new_vpc_id' => $this->new_vpc_id,
            'old_vpc_id' => $this->old_vpc_id,
        ];
    }
}
