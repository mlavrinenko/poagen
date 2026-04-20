<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CodeScanningDefaultSetup
{
    /**
     * @param ?list<string> $languages
     */
    public function __construct(
        public ?array $languages = null,
        public ?string $query_suite = null,
        public ?string $runner_label = null,
        public ?string $runner_type = null,
        public ?string $schedule = null,
        public ?string $state = null,
        public ?string $threat_model = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
