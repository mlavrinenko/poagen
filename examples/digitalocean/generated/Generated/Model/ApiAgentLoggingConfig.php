<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiAgentLoggingConfig
{
    public function __construct(
        public ?string $galileo_project_id = null,
        public ?string $galileo_project_name = null,
        public ?bool $insights_enabled = null,
        public ?DateTimeImmutable $insights_enabled_at = null,
        public ?string $log_stream_id = null,
        public ?string $log_stream_name = null,
    ) {
    }
}
