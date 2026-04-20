<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningAutofixStatus;

final readonly class CodeScanningAutofix
{
    public function __construct(
        public CodeScanningAutofixDescription $description,
        public CodeScanningAutofixStartedAt $started_at,
        public CodeScanningAutofixStatus $status,
    ) {
    }
}
