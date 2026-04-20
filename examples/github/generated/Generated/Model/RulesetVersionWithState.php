<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class RulesetVersionWithState
{
    /**
     * @param array<string, mixed> $state
     */
    public function __construct(
        public RulesetVersionWithStateActor $actor,
        public array $state,
        public DateTimeImmutable $updated_at,
        public int $version_id,
    ) {
    }
}
