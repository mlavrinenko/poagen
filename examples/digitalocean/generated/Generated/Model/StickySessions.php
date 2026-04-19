<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class StickySessions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cookie_name' => ['cookie_name', null],
        'cookie_ttl_seconds' => ['cookie_ttl_seconds', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?string $cookie_name = null,
        public ?int $cookie_ttl_seconds = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cookie_name' => $this->cookie_name,
            'cookie_ttl_seconds' => $this->cookie_ttl_seconds,
            'type' => $this->type,
        ];
    }
}
