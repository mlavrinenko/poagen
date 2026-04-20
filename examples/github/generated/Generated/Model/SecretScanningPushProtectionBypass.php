<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\SecretScanningPushProtectionBypassReason;
use DateTimeImmutable;

final readonly class SecretScanningPushProtectionBypass
{
    public function __construct(
        public ?DateTimeImmutable $expire_at = null,
        public ?SecretScanningPushProtectionBypassReason $reason = null,
        public ?string $token_type = null,
    ) {
    }
}
