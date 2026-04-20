<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CombinedCommitStatus
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\SimpleCommitStatus> $statuses
     */
    public function __construct(
        public string $commit_url,
        public MinimalRepository $repository,
        public string $sha,
        public string $state,
        public array $statuses,
        public int $total_count,
        public string $url,
    ) {
    }
}
