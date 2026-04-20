<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningAnalysisDeletion
{
    public function __construct(
        public ?string $confirm_delete_url = null,
        public ?string $next_analysis_url = null,
    ) {
    }
}
