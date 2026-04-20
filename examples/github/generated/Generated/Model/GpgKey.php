<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class GpgKey
{
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
}
