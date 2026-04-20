<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningDefaultSetupOptions
{
    public function __construct(
        public ?string $runner_label = null,
        public ?string $runner_type = null,
    ) {
    }
}
