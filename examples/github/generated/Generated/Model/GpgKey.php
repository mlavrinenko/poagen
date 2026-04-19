<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class GpgKey implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'can_certify' => ['can_certify', null],
        'can_encrypt_comms' => ['can_encrypt_comms', null],
        'can_encrypt_storage' => ['can_encrypt_storage', null],
        'can_sign' => ['can_sign', null],
        'created_at' => ['created_at', ['datetime', null]],
        'emails' => ['emails', ['list', null]],
        'expires_at' => ['expires_at', ['datetime', null]],
        'id' => ['id', null],
        'key_id' => ['key_id', null],
        'primary_key_id' => ['primary_key_id', null],
        'public_key' => ['public_key', null],
        'raw_key' => ['raw_key', null],
        'revoked' => ['revoked', null],
        'subkeys' => ['subkeys', ['list', null]],
        'name' => ['name', null],
    ];

    /**
     * @param list<array<string, mixed>> $emails
     * @param list<array<string, mixed>> $subkeys
     */
    public function __construct(
        public bool $can_certify,
        public bool $can_encrypt_comms,
        public bool $can_encrypt_storage,
        public bool $can_sign,
        public DateTimeImmutable $created_at,
        public array $emails,
        public ?DateTimeImmutable $expires_at = null,
        public int $id,
        public string $key_id,
        public ?int $primary_key_id = null,
        public string $public_key,
        public ?string $raw_key = null,
        public bool $revoked,
        public array $subkeys,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'can_certify' => $this->can_certify,
            'can_encrypt_comms' => $this->can_encrypt_comms,
            'can_encrypt_storage' => $this->can_encrypt_storage,
            'can_sign' => $this->can_sign,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'emails' => $this->emails,
            'expires_at' => $this->expires_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'key_id' => $this->key_id,
            'primary_key_id' => $this->primary_key_id,
            'public_key' => $this->public_key,
            'raw_key' => $this->raw_key,
            'revoked' => $this->revoked,
            'subkeys' => $this->subkeys,
            'name' => $this->name,
        ];
    }
}
