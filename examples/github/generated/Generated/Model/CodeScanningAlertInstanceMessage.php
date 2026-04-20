<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningAlertInstanceMessage
{
    public function __construct(
        public ?string $markdown = null,
        public ?string $text = null,
    ) {
    }
}
