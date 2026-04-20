<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleCodeScanningParameters
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\RepositoryRuleParamsCodeScanningTool> $code_scanning_tools
     */
    public function __construct(
        public array $code_scanning_tools,
    ) {
    }
}
