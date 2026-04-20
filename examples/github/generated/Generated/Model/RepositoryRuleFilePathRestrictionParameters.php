<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleFilePathRestrictionParameters
{
    /**
     * @param list<string> $restricted_file_paths
     */
    public function __construct(
        public array $restricted_file_paths,
    ) {
    }
}
