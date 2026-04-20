<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleFileExtensionRestrictionParameters
{
    /**
     * @param list<string> $restricted_file_extensions
     */
    public function __construct(
        public array $restricted_file_extensions,
    ) {
    }
}
