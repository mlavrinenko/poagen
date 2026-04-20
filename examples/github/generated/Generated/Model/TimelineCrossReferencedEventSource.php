<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TimelineCrossReferencedEventSource
{
    public function __construct(
        public ?Issue $issue = null,
        public ?string $type = null,
    ) {
    }
}
