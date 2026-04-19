<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GitCommitVerification implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'payload' => ['payload', null],
        'reason' => ['reason', null],
        'signature' => ['signature', null],
        'verified' => ['verified', null],
        'verified_at' => ['verified_at', null],
    ];

    public function __construct(
        public ?string $payload = null,
        public string $reason,
        public ?string $signature = null,
        public bool $verified,
        public ?string $verified_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'payload' => $this->payload,
            'reason' => $this->reason,
            'signature' => $this->signature,
            'verified' => $this->verified,
            'verified_at' => $this->verified_at,
        ];
    }
}
