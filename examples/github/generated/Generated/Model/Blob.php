<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Blob
{
    public function __construct(
        public string $content,
        public string $encoding,
        public string $node_id,
        public string $sha,
        public ?int $size = null,
        public string $url,
        public ?string $highlighted_content = null,
    ) {
    }
}
