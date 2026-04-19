<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CdnEndpoint implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'origin' => ['origin', null],
        'certificate_id' => ['certificate_id', null],
        'created_at' => ['created_at', ['datetime', null]],
        'custom_domain' => ['custom_domain', null],
        'endpoint' => ['endpoint', null],
        'id' => ['id', null],
        'ttl' => ['ttl', null],
    ];

    public function __construct(
        public string $origin,
        public ?string $certificate_id = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $custom_domain = null,
        public ?string $endpoint = null,
        public ?string $id = null,
        public ?int $ttl = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'origin' => $this->origin,
            'certificate_id' => $this->certificate_id,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'custom_domain' => $this->custom_domain,
            'endpoint' => $this->endpoint,
            'id' => $this->id,
            'ttl' => $this->ttl,
        ];
    }
}
