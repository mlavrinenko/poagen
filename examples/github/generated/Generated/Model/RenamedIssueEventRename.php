<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RenamedIssueEventRename
{
    public function __construct(
        public string $from,
        public string $to,
    ) {
    }
}
