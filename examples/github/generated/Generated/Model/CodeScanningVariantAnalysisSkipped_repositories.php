<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningVariantAnalysisSkipped_repositories
{
    public function __construct(
        public CodeScanningVariantAnalysisSkippedRepoGroup $access_mismatch_repos,
        public CodeScanningVariantAnalysisSkippedRepoGroup $no_codeql_db_repos,
        public CodeScanningVariantAnalysisSkipped_repositoriesNot_found_repos $not_found_repos,
        public CodeScanningVariantAnalysisSkippedRepoGroup $over_limit_repos,
    ) {
    }
}
