<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningAutofixCommitsResponse
{
    public function __construct(
        public ?string $sha = null,
        public ?string $target_ref = null,
    ) {
    }
}
