<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CheckRunWithSimpleCheckSuite
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\PullRequestMinimal> $pull_requests
     */
    public function __construct(
        public Integration $app,
        public SimpleCheckSuite $check_suite,
        public ?DateTimeImmutable $completed_at = null,
        public ?string $conclusion = null,
        public string $details_url,
        public string $external_id,
        public string $head_sha,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public CheckRunWithSimpleCheckSuiteOutput $output,
        public array $pull_requests,
        public DateTimeImmutable $started_at,
        public string $status,
        public string $url,
        public ?DeploymentSimple $deployment = null,
    ) {
    }
}
