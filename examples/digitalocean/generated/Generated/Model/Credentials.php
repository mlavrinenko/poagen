<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Credentials implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'certificate_authority_data' => ['certificate_authority_data', null],
        'client_certificate_data' => ['client_certificate_data', null],
        'client_key_data' => ['client_key_data', null],
        'expires_at' => ['expires_at', ['datetime', null]],
        'server' => ['server', null],
        'token' => ['token', null],
    ];

    public function __construct(
        public ?string $certificate_authority_data = null,
        public ?string $client_certificate_data = null,
        public ?string $client_key_data = null,
        public ?DateTimeImmutable $expires_at = null,
        public ?string $server = null,
        public ?string $token = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'certificate_authority_data' => $this->certificate_authority_data,
            'client_certificate_data' => $this->client_certificate_data,
            'client_key_data' => $this->client_key_data,
            'expires_at' => $this->expires_at?->format(\DateTimeInterface::RFC3339),
            'server' => $this->server,
            'token' => $this->token,
        ];
    }
}
