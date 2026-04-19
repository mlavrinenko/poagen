<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Certificate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'dns_names' => ['dns_names', ['list', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'not_after' => ['not_after', ['datetime', null]],
        'sha1_fingerprint' => ['sha1_fingerprint', null],
        'state' => ['state', null],
        'type' => ['type', null],
    ];

    /**
     * @param ?list<string> $dns_names
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?array $dns_names = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?DateTimeImmutable $not_after = null,
        public ?string $sha1_fingerprint = null,
        public ?string $state = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'dns_names' => $this->dns_names,
            'id' => $this->id,
            'name' => $this->name,
            'not_after' => $this->not_after?->format(\DateTimeInterface::RFC3339),
            'sha1_fingerprint' => $this->sha1_fingerprint,
            'state' => $this->state,
            'type' => $this->type,
        ];
    }
}
