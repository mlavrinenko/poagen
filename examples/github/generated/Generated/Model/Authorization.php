<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Authorization
{
    /**
     * @param ?list<string> $scopes
     */
    public function __construct(
        public AuthorizationApp $app,
        public DateTimeImmutable $created_at,
        public ?DateTimeImmutable $expires_at = null,
        public ?string $fingerprint = null,
        public ?string $hashed_token = null,
        public int $id,
        public ?string $note = null,
        public ?string $note_url = null,
        public ?array $scopes = null,
        public string $token,
        public ?string $token_last_eight = null,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?NullableScopedInstallation $installation = null,
        public ?NullableSimpleUser $user = null,
    ) {
    }
}
