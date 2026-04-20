<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningAlertRule
{
    /**
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?string $description = null,
        public ?string $full_description = null,
        public ?string $help = null,
        public ?string $help_uri = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $security_severity_level = null,
        public ?string $severity = null,
        public ?array $tags = null,
    ) {
    }
}
