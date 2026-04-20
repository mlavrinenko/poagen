<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class NullablePinnedIssueComment
{
    public function __construct(
        public DateTimeImmutable $pinned_at,
        public NullableSimpleUser $pinned_by,
    ) {
    }
}
