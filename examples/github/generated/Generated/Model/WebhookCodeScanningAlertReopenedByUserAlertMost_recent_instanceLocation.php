<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instanceLocation
{
    public function __construct(
        public ?int $end_column = null,
        public ?int $end_line = null,
        public ?string $path = null,
        public ?int $start_column = null,
        public ?int $start_line = null,
    ) {
    }
}
