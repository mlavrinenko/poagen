<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksAlert
{
    public function __construct(
        public string $affected_package_name,
        public string $affected_range,
        public string $created_at,
        public string $external_identifier,
        public ?string $external_reference = null,
        public string $ghsa_id,
        public int $id,
        public string $node_id,
        public int $number,
        public string $severity,
        public string $state,
        public ?string $dismiss_reason = null,
        public ?string $dismissed_at = null,
        public ?WebhooksAlertDismisser $dismisser = null,
        public ?string $fix_reason = null,
        public ?DateTimeImmutable $fixed_at = null,
        public ?string $fixed_in = null,
    ) {
    }
}
