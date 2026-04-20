<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PushEvent
{
    public function __construct(
        public string $before,
        public string $head,
        public int $push_id,
        public string $ref,
        public int $repository_id,
    ) {
    }
}
