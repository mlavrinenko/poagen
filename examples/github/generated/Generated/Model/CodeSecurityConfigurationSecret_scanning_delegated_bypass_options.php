<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeSecurityConfigurationSecret_scanning_delegated_bypass_options
{
    /**
     * @param ?list<array<string, mixed>> $reviewers
     */
    public function __construct(
        public ?array $reviewers = null,
    ) {
    }
}
