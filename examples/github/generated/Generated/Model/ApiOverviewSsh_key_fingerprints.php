<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ApiOverviewSsh_key_fingerprints implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'SHA256_DSA' => ['SHA256_DSA', null],
        'SHA256_ECDSA' => ['SHA256_ECDSA', null],
        'SHA256_ED25519' => ['SHA256_ED25519', null],
        'SHA256_RSA' => ['SHA256_RSA', null],
    ];

    public function __construct(
        public ?string $SHA256_DSA = null,
        public ?string $SHA256_ECDSA = null,
        public ?string $SHA256_ED25519 = null,
        public ?string $SHA256_RSA = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'SHA256_DSA' => $this->SHA256_DSA,
            'SHA256_ECDSA' => $this->SHA256_ECDSA,
            'SHA256_ED25519' => $this->SHA256_ED25519,
            'SHA256_RSA' => $this->SHA256_RSA,
        ];
    }
}
