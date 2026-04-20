<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class SimpleCheckSuite
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PullRequestMinimal> $pull_requests
     */
    public function __construct(
        public ?string $after = null,
        public ?Integration $app = null,
        public ?string $before = null,
        public ?string $conclusion = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $head_branch = null,
        public ?string $head_sha = null,
        public ?int $id = null,
        public ?string $node_id = null,
        public ?array $pull_requests = null,
        public ?MinimalRepository $repository = null,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
    ) {
    }
}
