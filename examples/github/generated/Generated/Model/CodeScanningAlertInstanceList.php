<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningAlertInstanceState;

final readonly class CodeScanningAlertInstanceList
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Enum\CodeScanningAlertClassification> $classifications
     */
    public function __construct(
        public ?CodeScanningAnalysisAnalysisKey $analysis_key = null,
        public ?CodeScanningAnalysisCategory $category = null,
        public ?array $classifications = null,
        public ?string $commit_sha = null,
        public ?CodeScanningAlertEnvironment $environment = null,
        public ?string $html_url = null,
        public ?CodeScanningAlertLocation $location = null,
        public ?CodeScanningAlertInstanceListMessage $message = null,
        public ?CodeScanningRef $ref = null,
        public ?CodeScanningAlertInstanceState $state = null,
    ) {
    }
}
