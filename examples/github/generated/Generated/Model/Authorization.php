<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Authorization implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'app' => ['app', \Acme\GitHub\Generated\Model\AuthorizationApp::class],
        'created_at' => ['created_at', ['datetime', null]],
        'expires_at' => ['expires_at', ['datetime', null]],
        'fingerprint' => ['fingerprint', null],
        'hashed_token' => ['hashed_token', null],
        'id' => ['id', null],
        'note' => ['note', null],
        'note_url' => ['note_url', null],
        'scopes' => ['scopes', ['list', null]],
        'token' => ['token', null],
        'token_last_eight' => ['token_last_eight', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\NullableScopedInstallation::class],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app' => $this->app,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'expires_at' => $this->expires_at?->format(\DateTimeInterface::RFC3339),
            'fingerprint' => $this->fingerprint,
            'hashed_token' => $this->hashed_token,
            'id' => $this->id,
            'note' => $this->note,
            'note_url' => $this->note_url,
            'scopes' => $this->scopes,
            'token' => $this->token,
            'token_last_eight' => $this->token_last_eight,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'installation' => $this->installation,
            'user' => $this->user,
        ];
    }
}
