<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class RulesetVersion
{
    public function __construct(
        public RulesetVersionActor $actor,
        public DateTimeImmutable $updated_at,
        public int $version_id,
    ) {
    }
}
