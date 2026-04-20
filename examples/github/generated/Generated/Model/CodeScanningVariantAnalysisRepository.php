<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CodeScanningVariantAnalysisRepository
{
    public function __construct(
        public string $full_name,
        public int $id,
        public string $name,
        public bool $private,
        public int $stargazers_count,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
