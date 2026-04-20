<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DiscussionEvent
{
    public function __construct(
        public string $action,
        public Discussion $discussion,
    ) {
    }
}
