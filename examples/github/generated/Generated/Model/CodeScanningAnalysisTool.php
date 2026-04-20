<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningAnalysisTool
{
    public function __construct(
        public ?CodeScanningAnalysisToolGuid $guid = null,
        public ?CodeScanningAnalysisToolName $name = null,
        public ?CodeScanningAnalysisToolVersion $version = null,
    ) {
    }
}
