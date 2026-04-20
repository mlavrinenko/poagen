<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\InteractionGroup;
use DateTimeImmutable;

final readonly class InteractionLimitResponse
{
    public function __construct(
        public DateTimeImmutable $expires_at,
        public InteractionGroup $limit,
        public string $origin,
    ) {
    }
}
