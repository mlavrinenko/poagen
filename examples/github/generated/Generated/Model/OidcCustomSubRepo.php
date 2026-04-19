<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class OidcCustomSubRepo implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'use_default' => ['use_default', null],
        'include_claim_keys' => ['include_claim_keys', ['list', null]],
    ];

    /**
     * @param ?list<string> $include_claim_keys
     */
    public function __construct(
        public bool $use_default,
        public ?array $include_claim_keys = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'use_default' => $this->use_default,
            'include_claim_keys' => $this->include_claim_keys,
        ];
    }
}
