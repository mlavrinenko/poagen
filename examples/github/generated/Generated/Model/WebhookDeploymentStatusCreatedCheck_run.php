<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookDeploymentStatusCreatedCheck_run
{
    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?string $conclusion = null,
        public string $details_url,
        public string $external_id,
        public string $head_sha,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public DateTimeImmutable $started_at,
        public string $status,
        public string $url,
    ) {
    }
}
