<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCodeScanningAlertReopenedByUserAlertRule
{
    public function __construct(
        public string $description,
        public string $id,
        public ?string $severity = null,
    ) {
    }
}
