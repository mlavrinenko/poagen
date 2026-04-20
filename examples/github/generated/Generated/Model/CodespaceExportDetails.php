<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CodespaceExportDetails
{
    public function __construct(
        public ?string $branch = null,
        public ?DateTimeImmutable $completed_at = null,
        public ?string $export_url = null,
        public ?string $html_url = null,
        public ?string $id = null,
        public ?string $sha = null,
        public ?string $state = null,
    ) {
    }
}
