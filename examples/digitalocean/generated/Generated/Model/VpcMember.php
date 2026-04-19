<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class VpcMember implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'name' => ['name', null],
        'urn' => ['urn', \Acme\DigitalOcean\Generated\Model\Urn::class],
    ];

    public function __construct(
        public ?string $created_at = null,
        public ?string $name = null,
        public ?Urn $urn = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'name' => $this->name,
            'urn' => $this->urn,
        ];
    }
}
