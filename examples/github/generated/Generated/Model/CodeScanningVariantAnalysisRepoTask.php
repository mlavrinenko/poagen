<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningVariantAnalysisStatus;

final readonly class CodeScanningVariantAnalysisRepoTask
{
    public function __construct(
        public CodeScanningVariantAnalysisStatus $analysis_status,
        public SimpleRepository $repository,
        public ?int $artifact_size_in_bytes = null,
        public ?string $artifact_url = null,
        public ?string $database_commit_sha = null,
        public ?string $failure_message = null,
        public ?int $result_count = null,
        public ?string $source_location_prefix = null,
    ) {
    }
}
