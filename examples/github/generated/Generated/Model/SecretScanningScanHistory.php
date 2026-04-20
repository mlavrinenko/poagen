<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningScanHistory
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningScan> $backfill_scans
     * @param ?list<mixed> $custom_pattern_backfill_scans
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningScan> $generic_secrets_backfill_scans
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningScan> $incremental_scans
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningScan> $pattern_update_scans
     */
    public function __construct(
        public ?array $backfill_scans = null,
        public ?array $custom_pattern_backfill_scans = null,
        public ?array $generic_secrets_backfill_scans = null,
        public ?array $incremental_scans = null,
        public ?array $pattern_update_scans = null,
    ) {
    }
}
