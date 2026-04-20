<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningAnalysis
{
    public function __construct(
        public CodeScanningAnalysisAnalysisKey $analysis_key,
        public CodeScanningAnalysisCommitSha $commit_sha,
        public CodeScanningAnalysisCreatedAt $created_at,
        public bool $deletable,
        public CodeScanningAnalysisEnvironment $environment,
        public string $error,
        public int $id,
        public CodeScanningRef $ref,
        public int $results_count,
        public int $rules_count,
        public CodeScanningAnalysisSarifId $sarif_id,
        public CodeScanningAnalysisTool $tool,
        public CodeScanningAnalysisUrl $url,
        public string $warning,
        public ?CodeScanningAnalysisCategory $category = null,
    ) {
    }
}
