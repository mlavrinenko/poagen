<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningDefaultSetupUpdate
{
    /**
     * @param ?list<string> $languages
     */
    public function __construct(
        public ?array $languages = null,
        public ?string $query_suite = null,
        public ?string $runner_label = null,
        public ?string $runner_type = null,
        public ?string $state = null,
        public ?string $threat_model = null,
    ) {
    }
}
