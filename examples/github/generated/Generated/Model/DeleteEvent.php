<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DeleteEvent
{
    public function __construct(
        public string $full_ref,
        public string $pusher_type,
        public string $ref,
        public string $ref_type,
    ) {
    }
}
