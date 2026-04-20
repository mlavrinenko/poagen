<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class IssueEventRename
{
    public function __construct(
        public string $from,
        public string $to,
    ) {
    }
}
