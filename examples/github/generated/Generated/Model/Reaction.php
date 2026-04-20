<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Reaction
{
    public function __construct(
        public string $content,
        public DateTimeImmutable $created_at,
        public int $id,
        public string $node_id,
        public NullableSimpleUser $user,
    ) {
    }
}
