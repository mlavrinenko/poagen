<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PublicIp implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enabled' => ['enabled', null],
        'length' => ['length', null],
        'prefix' => ['prefix', null],
    ];

    public function __construct(
        public ?bool $enabled = null,
        public ?int $length = null,
        public ?string $prefix = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enabled' => $this->enabled,
            'length' => $this->length,
            'prefix' => $this->prefix,
        ];
    }
}
