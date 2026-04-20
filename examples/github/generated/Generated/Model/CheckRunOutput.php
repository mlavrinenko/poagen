<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CheckRunOutput
{
    public function __construct(
        public int $annotations_count,
        public string $annotations_url,
        public ?string $summary = null,
        public ?string $text = null,
        public ?string $title = null,
    ) {
    }
}
