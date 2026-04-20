<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CheckRun
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\PullRequestMinimal> $pull_requests
     */
    public function __construct(
        public NullableIntegration $app,
        public CheckRunCheck_suite $check_suite,
        public ?DateTimeImmutable $completed_at = null,
        public ?string $conclusion = null,
        public ?string $details_url = null,
        public ?string $external_id = null,
        public string $head_sha,
        public ?string $html_url = null,
        public int $id,
        public string $name,
        public string $node_id,
        public CheckRunOutput $output,
        public array $pull_requests,
        public ?DateTimeImmutable $started_at = null,
        public string $status,
        public string $url,
        public ?DeploymentSimple $deployment = null,
    ) {
    }
}
