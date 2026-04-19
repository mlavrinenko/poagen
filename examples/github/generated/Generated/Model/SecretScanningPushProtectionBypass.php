<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\SecretScanningPushProtectionBypassReason;
use DateTimeImmutable;
use JsonSerializable;

final readonly class SecretScanningPushProtectionBypass implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'expire_at' => ['expire_at', ['datetime', null]],
        'reason' => ['reason', ['enum', \Acme\GitHub\Generated\Enum\SecretScanningPushProtectionBypassReason::class]],
        'token_type' => ['token_type', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $expire_at = null,
        public ?SecretScanningPushProtectionBypassReason $reason = null,
        public ?string $token_type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'expire_at' => $this->expire_at?->format(\DateTimeInterface::RFC3339),
            'reason' => $this->reason,
            'token_type' => $this->token_type,
        ];
    }
}
