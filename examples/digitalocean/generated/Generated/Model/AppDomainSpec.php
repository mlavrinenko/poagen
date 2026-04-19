<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppDomainSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'domain' => ['domain', null],
        'minimum_tls_version' => ['minimum_tls_version', null],
        'type' => ['type', null],
        'wildcard' => ['wildcard', null],
        'zone' => ['zone', null],
    ];

    public function __construct(
        public string $domain,
        public ?string $minimum_tls_version = null,
        public ?string $type = null,
        public ?bool $wildcard = null,
        public ?string $zone = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'domain' => $this->domain,
            'minimum_tls_version' => $this->minimum_tls_version,
            'type' => $this->type,
            'wildcard' => $this->wildcard,
            'zone' => $this->zone,
        ];
    }
}
