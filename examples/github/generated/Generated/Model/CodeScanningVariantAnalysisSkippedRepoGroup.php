<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningVariantAnalysisSkippedRepoGroup
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisRepository> $repositories
     */
    public function __construct(
        public array $repositories,
        public int $repository_count,
    ) {
    }
}
