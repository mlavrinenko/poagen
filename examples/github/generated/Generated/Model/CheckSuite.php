<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CheckSuite
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PullRequestMinimal> $pull_requests
     */
    public function __construct(
        public ?string $after = null,
        public NullableIntegration $app,
        public ?string $before = null,
        public string $check_runs_url,
        public ?string $conclusion = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $head_branch = null,
        public SimpleCommit $head_commit,
        public string $head_sha,
        public int $id,
        public int $latest_check_runs_count,
        public string $node_id,
        public ?array $pull_requests = null,
        public MinimalRepository $repository,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
        public ?bool $rerequestable = null,
        public ?bool $runs_rerequestable = null,
    ) {
    }
}
