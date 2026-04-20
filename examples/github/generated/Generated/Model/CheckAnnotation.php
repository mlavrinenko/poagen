<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CheckAnnotation
{
    public function __construct(
        public ?string $annotation_level = null,
        public string $blob_href,
        public ?int $end_column = null,
        public int $end_line,
        public ?string $message = null,
        public string $path,
        public ?string $raw_details = null,
        public ?int $start_column = null,
        public int $start_line,
        public ?string $title = null,
    ) {
    }
}
