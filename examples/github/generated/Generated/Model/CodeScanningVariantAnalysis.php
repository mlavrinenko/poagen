<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningVariantAnalysisLanguage;
use DateTimeImmutable;

final readonly class CodeScanningVariantAnalysis
{
    /**
     * @param ?list<array<string, mixed>> $scanned_repositories
     */
    public function __construct(
        public SimpleUser $actor,
        public SimpleRepository $controller_repo,
        public int $id,
        public CodeScanningVariantAnalysisLanguage $query_language,
        public string $query_pack_url,
        public string $status,
        public ?int $actions_workflow_run_id = null,
        public ?DateTimeImmutable $completed_at = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $failure_reason = null,
        public ?array $scanned_repositories = null,
        public ?CodeScanningVariantAnalysisSkipped_repositories $skipped_repositories = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
