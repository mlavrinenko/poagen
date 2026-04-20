<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningDefaultSetupUpdateResponse
{
    public function __construct(
        public ?int $run_id = null,
        public ?string $run_url = null,
    ) {
    }
}
