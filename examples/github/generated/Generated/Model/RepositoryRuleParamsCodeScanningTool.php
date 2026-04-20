<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleParamsCodeScanningTool
{
    public function __construct(
        public string $alerts_threshold,
        public string $security_alerts_threshold,
        public string $tool,
    ) {
    }
}
