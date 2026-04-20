<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningVariantAnalysisSkipped_repositoriesNot_found_repos
{
    /**
     * @param list<string> $repository_full_names
     */
    public function __construct(
        public int $repository_count,
        public array $repository_full_names,
    ) {
    }
}
