<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningAutofixCommits
{
    public function __construct(
        public ?string $message = null,
        public ?string $target_ref = null,
    ) {
    }
}
