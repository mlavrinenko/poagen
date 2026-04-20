<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReleaseNotesContent
{
    public function __construct(
        public string $body,
        public string $name,
    ) {
    }
}
