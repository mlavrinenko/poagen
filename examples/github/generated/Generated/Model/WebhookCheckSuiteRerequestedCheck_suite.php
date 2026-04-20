<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCheckSuiteRerequestedCheck_suite
{
    /**
     * @param list<array<string, mixed>> $pull_requests
     */
    public function __construct(
        public ?string $after = null,
        public WebhookCheckSuiteRerequestedCheck_suiteApp $app,
        public ?string $before = null,
        public string $check_runs_url,
        public ?string $conclusion = null,
        public DateTimeImmutable $created_at,
        public ?string $head_branch = null,
        public WebhookCheckSuiteRerequestedCheck_suiteHead_commit $head_commit,
        public string $head_sha,
        public int $id,
        public int $latest_check_runs_count,
        public string $node_id,
        public array $pull_requests,
        public ?string $status = null,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?bool $rerequestable = null,
        public ?bool $runs_rerequestable = null,
    ) {
    }
}
