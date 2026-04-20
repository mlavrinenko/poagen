<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Activity
{
    public function __construct(
        public string $activity_type,
        public NullableSimpleUser $actor,
        public string $after,
        public string $before,
        public int $id,
        public string $node_id,
        public string $ref,
        public DateTimeImmutable $timestamp,
    ) {
    }
}
