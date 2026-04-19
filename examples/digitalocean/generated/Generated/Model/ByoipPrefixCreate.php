<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ByoipPrefixCreate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'prefix' => ['prefix', null],
        'region' => ['region', null],
        'signature' => ['signature', null],
    ];

    public function __construct(
        public string $prefix,
        public string $region,
        public string $signature,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'prefix' => $this->prefix,
            'region' => $this->region,
            'signature' => $this->signature,
        ];
    }
}
