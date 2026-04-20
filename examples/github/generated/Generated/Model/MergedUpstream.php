<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MergedUpstream
{
    public function __construct(
        public ?string $base_branch = null,
        public ?string $merge_type = null,
        public ?string $message = null,
    ) {
    }
}
